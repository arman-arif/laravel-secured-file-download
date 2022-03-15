<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileUploadRequest;
use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index()
    {
        $files = File::latest()->get();
        return view('upload-download', compact('files'));
    }

    public function store(FileUploadRequest $request)
    {
        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $name = $file->getClientOriginalName();
                $uniqueName = uniqid(md5($name) . '_', true);
                // $file->move(public_path('uploads'), $name);
                $file->storeAs('uploads', $uniqueName);
                $path = storage_path("app/uploads", $uniqueName);
                // dd($file);
                $file = File::create([
                    'name' => $name,
                    'file' => $uniqueName,
                    'path' => base64_encode($path),
                    'ext'  => $file->getClientOriginalExtension(),
                    'type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ]);
                return redirect()->route('index')->with('success', 'File Uploaded Successfully.');
                // return response()->json(['success' => $file]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function download($uuid)
    {
        try {
            $file = File::where('id', $uuid)->firstOrFail();
            $file->downloads += 1;
            $file->save();
            // $path = base64_decode($file->path);
            // return response()->download($path, $file->name);
            $pathToFile = storage_path('app/uploads/' . $file->file);
            return response()->download($pathToFile, $file->name);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
