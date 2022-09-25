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

}
