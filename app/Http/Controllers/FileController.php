<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class FileController extends Controller
{
    public function create() {

        $files= File::all();
        $files = $files->map(function($item) {
            $item['download_url'] = Storage::disk('s3')->temporaryUrl($item->url, now()->addMinutes(15));
            return $item;
        });

        return Inertia::render('Files', [
            'files' => $files,
        ]);

    }

    public function store(Request $request) {
        //dd($request->file('file'));

        // in .env FILESYSTEM_DISK is set to s3; if not we need to Storage::disk('s3')...
        $result = Storage::put('my-image.jpg', $request->file('file'));

        if( ! $result) {
            return back()->with('error', 'Failed to store the file');
        }
        //dd($result);

        File::create([
            'name' => 'A name random here',
            'summary' => 'A dummy summary here',
            'url' => $result,
        ]);

        return back()->with('success', 'File stored successfully');
    }


    public function destroy(File $file) {

        Storage::disk('s3')->delete($file->url);

        $file->delete();

        return back()->with('success', 'Successfully deleted the file');
    }

    public function allFiles() {

        $files = Storage::disk('s3')->allFiles();

        $seeFiles = true;
        if( $seeFiles) {
            dd($files);
        }
        foreach($files as $file) {
            Storage::disk('s3')->delete($file);
        }
        dd($files, "current files:", Storage::disk('s3')->allFiles());
    }
}
