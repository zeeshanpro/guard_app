<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use App\Models\Folder;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx,txt',
            'folder_id' => 'sometimes|string'
        ]);

        $folderId = $request->input('folder_id');
        $userDirectory = 'user_' . auth()->id(); // Generate a unique directory name for the user
        $disk = 'local'; // Replace with the name of the storage disk (e.g., 'public', 'local', 's3', etc.)


        if ($request->file('file')->isValid()) {

            // Determine the path where you want to create the file
            $parent_folder =  Folder::where('id', $folderId)->first();
            
            $folderPath = $userDirectory; // Combine the user's directory with the file name
            $folderPath = $parent_folder ? $parent_folder->path : $folderPath;

            $path = $request->file('file')->store($folderPath,$disk); // Store the file in the 'uploads' directory

            $file = new File();
            //$file->user_id = auth()->id();
            $file->folder_id = $folderId;
            $file->name = $request->file('file')->getClientOriginalName();
            $file->path = $path;
            $file->save();

            return response()->json(['message' => 'File uploaded successfully' ,'$path' => $path], 200);
        } else {
            return response()->json(['message' => 'File upload failed'], 400);
        }
    }

    public function update(Request $request, $id)
    {
        // Implement the update logic for files here
    }

    public function delete($id)
    {
        $file = File::find($id);

        if (!$file) {
            return response()->json(['message' => 'File not found'], 404);
        }

        // if ($file->user_id !== auth()->id()) {
        //     return response()->json(['message' => 'Unauthorized'], 403);
        // }

        // Delete the file from storage and database
        Storage::delete($file->path);
        $file->delete();

        return response()->json(['message' => 'File deleted successfully'], 200);
    }
}
