<?php
namespace Blytd\MediaManager\Service;

use Blytd\MediaManager\Repository\Contract\MediaRepositoryInterface;
use Carbon\Carbon;
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
        $now = Carbon::now();
        $folderName = $now->year . "-" . $now->month;
        $mediaName = (string)Uuid::uuid4();
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
            'types' => ['original'],
            'path' => $baseFilePath,
            'model' => $data['model'] ?? null,
            'model_id' => $data['model_id'] ?? null,
            'access_type' => 'public',
        ];
        $file = $this->mediaRepository->create($fileAttributes);

        return [$linkData, $file];
    }

    public function delete($data)
    {
        if (!empty($data['media_id'])) {
            $file = $this->mediaRepository->findById($data['media_id']);
            foreach($file->types as $type) {
                if (Storage::disk('minio')->exists($type . '/' . $file['path'])) {
                    Storage::disk('minio')->delete($type . '/' . $file['path']);
                }
                $this->mediaRepository->delete($data['media_id']);
            }
        } else {
            if (Storage::disk('minio')->exists($data['path'])) {
                Storage::disk('minio')->delete( $data['path']);
            }
        }
        return true;
    }
}
