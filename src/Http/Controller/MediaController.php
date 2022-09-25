<?php

namespace Blytd\MediaManager\Http\Controller;

use App\Service\FileManager\ImageService;
use Blytd\MediaManager\Http\Request\MediaDeleteRequest;
use Blytd\MediaManager\Http\Request\MediaUploadRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;

class MediaController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function upload(
        MediaUploadRequest $request,
        ImageService $imageService
    )
    {
        $data = $request->all();
        list($linkData, $file) = $imageService->upload($data);

        return response()->json([
            'status' => 'success',
            'data' => ['file' => $file, 'link_data' => $linkData],
            'message' => __('messages.success.image.upload'),
        ], Response::HTTP_OK);
    }

    public function delete(
        MediaDeleteRequest $request,
        ImageService $imageService,
        $fileId = null
    )
    {
        $data = $request->all();
        $imageService->delete($data);
        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.image.delete'),
        ], Response::HTTP_NO_CONTENT);
    }
}