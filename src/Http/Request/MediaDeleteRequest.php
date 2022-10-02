<?php

namespace Blytd\MediaManager\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class MediaDeleteRequest extends FormRequest
{
    public function rules(): array
    {

        return [
            'media_id' => 'required_without:path|exists:media,_id,deleted_at,NULL',
            'path' => 'required_without:file_id|string'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function getValidatorInstance()
    {
        $data = $this->all();
        if ($this->route('media_id')) {
            $data['media_id'] = $this->route('media_id');
            $this->getInputSource()->replace($data);
        }
        return parent::getValidatorInstance();
    }
}