<?php

use Illuminate\Support\Facades\Route;
use Blytd\MediaManager\Http\Controller\MediaController;

Route::name('image.')->prefix('v1/image')->group(function (){
    Route::post('/upload',[MediaController::class, 'upload'])->name('upload');
    Route::delete('/delete/{file_id?}',[MediaController::class, 'delete'])->name('delete');
});