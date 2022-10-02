<?php

namespace Blytd\MediaManager\Model;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes;

    const ACCEPTABLE_MODELS = [
        'User',
        'Preamble'
    ];

    protected $dates = [
        'deleted_at'
    ];

    protected $hidden = [
        '_id'
    ];

    protected $appends = [
        'id'
    ];

    protected $fillable = [
        "origin_name",
        "mime",
        'bucket',
        'types',
        "path",
        "model",
        "model_id",
        "extra_data",
        "access_type",
    ];
}