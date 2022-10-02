<?php

namespace Blytd\MediaManager\Http\Controller;

use Blytd\MediaManager\Http\Request\MediaDeleteRequest;
use Blytd\MediaManager\Http\Request\MediaUploadRequest;
use Blytd\MediaManager\Service\MediaService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;

class MediaController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function upload(
        MediaUploadRequest $request,
        MediaService $mediaService
    )
    {
        $data = $request->all();
        dd('ssssssssssssss');
        list($linkData, $file) = $mediaService->upload($data);

        return response()->json([
            'status' => 'success',
            'data' => ['file' => $file, 'link_data' => $linkData],
            'message' => __('messages.success.image.upload'),
        ], Response::HTTP_OK);
    }

    public function delete(
        MediaDeleteRequest $request,
        MediaService $mediaService,
        $fileId = null
    )
    {
        $data = $request->all();
        $mediaService->delete($data);
        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.image.delete'),
        ], Response::HTTP_NO_CONTENT);
    }
}