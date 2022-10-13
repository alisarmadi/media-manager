<?php

namespace Blytd\MediaManager\Repository\MongoDB;

use Blytd\MediaManager\Model\Media;
use Blytd\MediaManager\Repository\Contract\MediaRepositoryInterface;

class MediaRepository extends BaseRepository implements MediaRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(Media::class);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findByPath($path)
    {
        return $this->model
            ->where('path', $path)
            ->first();
    }

    /**
     * @param $id
     * @param $fileFormat
     * @return mixed
     */
    public function deleteFileFormat($id, $fileFormat)
    {
        return $this->model
            ->where('_id', $id)
            ->pull('formats', $fileFormat);
    }

}
