<?php

namespace App\Jobs;

use App\Models\File;
use App\Services\BasePromptService;
use App\Services\BunnyTokenGenerationService;
use App\Services\GeminiService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessFileSubmission implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public File $file,
    )
    { }

    /**
     * Execute the job.
     */
    public function handle(BunnyTokenGenerationService $tokenService, GeminiService $geminiService, BasePromptService $basePromptService): void
    {
        //$this->file;

        // Get the file to be processed
        $file_url = $tokenService->sign_bcdn_url($this->file->url, "", 60); // create the tokenized link for download

        $response = Http::get($file_url);    // get the file

        // Get the file content (binary data)
        $fileContent = $response->body();

        // Encode the file content to base64
        $encodedFileContent = base64_encode($fileContent);

        $content_type = $response->header('Content-Type');
Log::info('Response status: ' . $response->status());
Log::info('Response headers: ', $response->headers());
Log::info('Content type is: '. $content_type);
//Log::info('Response body snippet: ' . substr($response->body(), 0, 100)); // Avoid logging full file content
        /*
 * If the file is an image
 * we send it for processing
 *
 * If the file is a pdf
 * we get the content and send it instead
 * */

        Log::info('logged from the queue job');
        Log::info($this->file->name);

        // send the file to gemini
        if (in_array($content_type, ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml', 'image/bmp', 'image/tiff'])) {
            $responseText = $geminiService->sendFileContent($encodedFileContent, $basePromptService->buildPromptForFileProcessing());

            $start = strpos($responseText, '{');
            $end = strpos($responseText, '}');
            $json = substr($responseText, $start, $end + 1 - $start);
            $responseArray = json_decode($json, true);
            $this->file->name = $responseArray['name'];
            $this->file->summary = $responseArray['summary'];
            $this->file->save();
        }


        Log::info($responseText);


    }
}
