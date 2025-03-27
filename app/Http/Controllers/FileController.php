<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidBunnyClientException;
use App\Jobs\ProcessFileSubmission;
use App\Models\File;
use App\Services\BunnyTokenGenerationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class FileController extends Controller
{
    public function create(BunnyTokenGenerationService $tokenService) {

        $files= File::all();
        $files = $files->map(function($item) use ($tokenService) {
            $item['direct_download_url'] = $tokenService->sign_bcdn_url($item->url, "", 3600);
            return $item;
        });

        return Inertia::render('Files', [
            'files' => $files,
        ]);

    }

    public function store(Request $request) {
        // validate that the file exists
        $request->validate([
            'file' => 'required',
        ]);
        // create storage service
        $accessKey = config('filesystems.bunny-storage.access-key');
        $storageZoneName = config('filesystems.bunny-storage.storage-zone-name');
        try {

            //throw new InvalidBunnyClientException("This is a forced exception");

            $client = new \Bunny\Storage\Client($accessKey, $storageZoneName, \Bunny\Storage\Region::FALKENSTEIN);
        } catch (Exception $e) {

            throw new InvalidBunnyClientException();
            return back()->with('error', $e->getMessage());

        }

        // create file data
        $filename = Str::uuid();
        $extension = $request->file->extension();
        $filePath = "/" . $filename . '.' . $extension;
        // store the file
        $client->upload($request->file->path(), $filePath);
        // create the local record withe the file's path (uuid now)
        $file = File::create([
            'name' => $request->file->getClientOriginalName(),
            'summary' => 'A dummy summary here',
            'url' => $filePath,
        ]);



        if(false) {
            dd("error");
            return back()->with('error', 'Failed to store the file');
        }

        // launch the AI job here
        ProcessFileSubmission::dispatchAfterResponse($file);

        return back()->with('success', 'File stored successfully');
    }

    public function destroy(File $file) {


        $accessKey = config('filesystems.bunny-storage.access-key');
        $storageZoneName = config('filesystems.bunny-storage.storage-zone-name');

        $client = new \Bunny\Storage\Client($accessKey, $storageZoneName, \Bunny\Storage\Region::FALKENSTEIN);

        $client->delete($file->url);

        $file->delete();

        return back()->with('success', 'Successfully deleted the file');
    }

    public function allFiles() {

        $accessKey = config('filesystems.bunny-storage.access-key');
        $storageZoneName = config('filesystems.bunny-storage.storage-zone-name');

        $client = new \Bunny\Storage\Client($accessKey, $storageZoneName, \Bunny\Storage\Region::FALKENSTEIN);

        $files = $client->listFiles('/');
        $seeFiles = true;
        if( $seeFiles) {
            dd($files);
        }
        foreach($files as $file) {

            dd('update the delete all files here');
        }
        dd($files, "current files:", Storage::disk('s3')->allFiles());
    }
}
