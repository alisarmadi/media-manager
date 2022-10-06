# Simple media manager

This package can associate some sorts of media with Eloquent models. It provides some
simple APIs to work with.

## Installation
For install this library do these steps:
- Add this line to require section of the composer.json
```
"blytd/media-manager": "^1.0.0"
```
- And also add this section in the composer.json file:
```
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/alisarmadi/media-manager"
        }
    ],
```
- On the end you should have something like this in your composer.json file:
```
    ...
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/alisarmadi/media-manager"
        }
    ],
    "require": {
        ...
        "blytd/media-manager": "^1.0.0"
    },
    ...
```
- Then add this line to the app.php file in the config directory of your project:
```php
    \Blytd\MediaManager\Provider\MediaManagerProvider::class
```

## Usage
For use the library you have to add this routes to your project routes:
```php
Route::name('media.')->prefix('media')->group(function (){
   Route::post('/upload',[\Blytd\MediaManager\Http\Controller\MediaController::class, 'upload'])->name('upload');
        Route::delete('/delete/{media_id?}',[\Blytd\MediaManager\Http\Controller\MediaController::class, 'delete'])->name('delete');
});
```
#### Note: Please be careful to wrap these routes in the appropriate middleware to control access to them. Something like this:
```php
Route::middleware('auth')->group(function (){
    Route::name('media.')->prefix('media')->group(function (){
   Route::post('/upload',[\Blytd\MediaManager\Http\Controller\MediaController::class, 'upload'])->name('upload');
        Route::delete('/delete/{media_id?}',[\Blytd\MediaManager\Http\Controller\MediaController::class, 'delete'])->name('delete');
    });
});
```

For use the library you have two endpoints for upload and delete, you can access those With these routes:
```
    POST {{base_path}}{/api}/media/upload
    PAYLOAD (form-data)
        media: (Selected file)
        model: (Can be one of your model name, it's an optional parameter)
        model_id: (Id of the selected model, it's an optional parameter)

```
```
    DELETE {{base_path}}{/api}/media/delete/{media_id}
    PAYLOAD
        {
            "path": "original/2022-9/37da58f9-2236-440b-8c3f-7f96fad39477.jpeg"
        }
    You must set one of the 'media_id' or 'path' param in this endpoint to delete the desired media.    

```

## Optional usage
You can publish the MediaController with the line below and customize it if necessary.
```
    php artisan vendor:publish --tag=blytd-media-controller
```
