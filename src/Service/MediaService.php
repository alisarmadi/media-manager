<?php
namespace Blytd\MediaManager\Service;

use Blytd\MediaManager\Repository\Contract\MediaRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class MediaService {

    private $basePath;
    private $bucket;

    public function __construct( protected MediaRepositoryInterface $mediaRepository ) {
        $this->basePath = config('filesystems.disks.minio.endpoint');
        $this->bucket = config('filesystems.disks.minio.bucket');
    }

    public function upload($data)
    {
        $folderName = $data['model'] ?? 'Global_Model';
        $mediaName = (isset($data['model_id']) ? $data['model_id'] . '_' : '') . (string)Uuid::uuid4();
        $mediaExtension = $data['media']->getClientOriginalExtension();
        $baseFilePath = $folderName . '/' . $mediaName . '.' . $mediaExtension;
        $originalFilePath = Storage::disk('minio')->putFileAs(
            'original/' . $folderName,
            $data['media'],
            $mediaName . '.' . $mediaExtension,
            'public'
        );

        $linkData['base_url'] = $this->basePath;
        $linkData['size'] = [
            'original' => "$this->basePath/$this->bucket/$originalFilePath",
        ];

        $fileAttributes = [
            'origin_name' => $data['media']->getClientOriginalName(),
            'mime' => $data['media']->getMimeType(),
            'bucket' => $this->bucket,
            'type' => $data['type'],
            'formats' => ['original'],
            'path' => $baseFilePath,
            'model' => $data['model'] ?? null,
            'model_id' => $data['model_id'] ?? null,
            'extra_data' => $data['extra_data'] ?? null,
            'access_type' => 'public',
        ];
        $file = $this->mediaRepository->create($fileAttributes);

        return [$linkData, $file];
    }

    public function delete($data)
    {
        if (!empty($data['media_id'])) {
            $file = $this->mediaRepository->findById($data['media_id']);
            foreach($file->formats as $format) {
                if (Storage::disk('minio')->exists($format . '/' . $file['path'])) {
                    Storage::disk('minio')->delete($format . '/' . $file['path']);
                } else {
                    abort(Response::HTTP_NOT_FOUND,  'File not found.');
                }
                $this->mediaRepository->delete($data['media_id']);
            }
        } else {
            if (Storage::disk('minio')->exists($data['path'])) {
                Storage::disk('minio')->delete( $data['path']);

                $firstSlashPos = strpos($data['path'], '/');
                $format = substr($data['path'], 0, $firstSlashPos);
                $path = substr($data['path'], $firstSlashPos + 1);

                $file = $this->mediaRepository->findByPath($path);
                if ($file) {
                    if ( in_array($format, $file->formats) && count($file->formats) == 1) {
                        $this->mediaRepository->delete($file->id);
                    } else if (in_array($format, $file->formats) && count($file->formats) > 1){
                        $this->mediaRepository->deleteFileFormat($file->id, $format);
                    }
                }

            } else {
                abort(Response::HTTP_NOT_FOUND,  'File not found.');
            }
        }
        return true;
    }
}
