<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Folder;

class FolderController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'folder_name' => 'required|string',
            'parent_folder' => 'sometimes|string', // If you want to create a subfolder within an existing folder
        ]);

        $folderName = $request->input('folder_name');
        $parentFolder = $request->input('parent_folder');
        $userDirectory = 'user_' . auth()->id(); // Generate a unique directory name for the user
        $folderPath = $userDirectory . '/' . $folderName; // Combine the user's directory with the file name
        $disk = "local";// Replace with the name of the disk you want to use (e.g., 'public', 'local', 's3', etc.)

       
        try {
            
            // Determine the path where you want to create the folder
            $parent_folder =  Folder::where('id', $parentFolder)->first();
          
            $folderPath = $parent_folder ? $parent_folder->path . '/' . $folderName : $folderPath;
            $parent_id = $parent_folder ? $parent_folder->id : null;
            
            // Use the Storage facade's exists() method to check if the folder exists
            if (Storage::disk($disk)->exists($folderPath)) {
                return response()->json(['message' => 'Folder exists'], 200);
            } else {

                //Create Folder
                Storage::disk($disk)->makeDirectory($folderPath);

                //Create Folder Record in Database
                $folder = new Folder();
                $folder->user_id = auth()->id();
                $folder->parent_id = $parent_id;
                $folder->name = $folderName;
                $folder->path = $folderPath;
                $folder->save();
                
                return response()->json(['message' => 'Folder created successfully'], 201);
            }

        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to create folder'], 500);
        }
    }

    public function delete($id)
    {
        // $request->validate([
        //     'folder_name' => 'required|string',
        //     'parent_folder' => 'sometimes|string',
        // ]);
        
        $folder =  Folder::where('id', $id)->first();
        
        // $folderName = $request->input('folder_name'); // Replace with the name of the folder you want to delete
        // $parentFolder = $request->input('parent_folder');
        $disk = 'local'; // Replace with the name of the disk where the folder is located (e.g., 'public', 'local', 's3', etc.)

        //$folderPath = $parentFolder ? $parentFolder . '/' . $folderName : $folderName;
        $folderPath = $folder->path;
        try {
            Storage::disk($disk)->deleteDirectory($folderPath);
            $folder->delete();
            
            return response()->json(['message' => 'Folder deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to delete folder'], 500);
        }
    }

}
