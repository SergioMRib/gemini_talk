<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;


class GeminiService
{
    protected $apiUrl;

    public function __construct()
    {
        // Define the API URL (could be set in .env for flexibility)
        $this->apiUrl = config('services.gemini.url'); // Assuming API URL is stored in .env
    }

    /**
     * Send content to the API
     *
     * @param string $text
     * @return \Illuminate\Http\Client\Response
     */
    public function sendContent(string $text)
    {

        // Prepare the JSON payload
        $payload = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $text
                        ]
                    ]
                ]
            ]
        ];

        // USING GUZZLE HHTP
        $client = new Client();
//dd(config('services.gemini.api_key'), $this->apiUrl);
        $response = $client->post($this->apiUrl, [
            'query' => ['key' => config('services.gemini.api_key')],
            'json' => $payload // Payload to send to the API
        ]);

//dd($response);
        // Decode the JSON response into an associative array
        $responseData = json_decode($response->getBody()->getContents(), true);

        // Navigate through the array to access the 'text' field
        $text = $responseData['candidates'][0]['content']['parts'][0]['text'];

        return $text;
    }
}

