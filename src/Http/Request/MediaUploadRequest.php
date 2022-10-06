<?php

namespace Blytd\MediaManager\Http\Request;

use Blytd\MediaManager\Model\Media;
use Illuminate\Foundation\Http\FormRequest;

class MediaUploadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'media' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'model' => 'string',
            'model_id' => 'string',
            'extra_data' => 'array'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

}