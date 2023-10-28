<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['auth:api']], function () {
    // Your API routes that require authentication go here

    // Example routes:
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/files', 'App\Http\Controllers\API\FileController@upload');
    Route::put('/files/{id}', 'App\Http\Controllers\API\FileController@update');
    Route::delete('/files/{id}', 'App\Http\Controllers\API\FileController@delete');

    // Route::post('/folders', 'App\Http\Controllers\API\FolderController@create');
    // Route::put('/folders/{id}', 'YourNamespace\FolderController@update');
    Route::delete('/folders/{id}', 'App\Http\Controllers\API\FolderController@delete');
});

//Route::middleware('auth:api')->post('/files', [FileController::class, 'upload']);
//Route::middleware('auth:api')->delete('/files/{id}', [FileController::class, 'delete']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/getfiles', 'App\Http\Controllers\API\FileController@getFiles');
Route::get('/getfolders', 'App\Http\Controllers\API\FolderController@getFolders');
Route::post('/folders', 'App\Http\Controllers\API\FolderController@create');
