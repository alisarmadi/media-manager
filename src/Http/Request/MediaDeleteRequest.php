<?php

namespace Blytd\MediaManager\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class MediaDeleteRequest extends FormRequest
{
    public function rules(): array
    {

        return [
            'file_id' => 'required_without:path|exists:files,_id,deleted_at,NULL',
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
        if ($this->route('file_id')) {
            $data['file_id'] = $this->route('file_id');
            $this->getInputSource()->replace($data);
        }
        return parent::getValidatorInstance();
    }
}