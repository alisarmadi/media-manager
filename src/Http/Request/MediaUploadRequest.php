<?php

namespace Blytd\MediaManager\Http\Request;

use Blytd\MediaManager\Model\Media;
use Illuminate\Foundation\Http\FormRequest;

class MediaUploadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'media' => 'required|file|mimes:pdf,xls,xlsx,doc,docx,ppt,pptx,pps,jpeg,png,jpg,gif,svg|max:4096',
            'model' => 'string',
            'model_id' => 'string',
            'type' => 'in:IMAGE,VIDEO,DOC,OTHER',
            'extra_data' => 'array'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

}