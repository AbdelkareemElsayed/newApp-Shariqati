<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class staticPagesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title_*'   => 'required',
            'content_*' => 'required',
            'keywords'  => 'required',
            'image'     => 'required|image|mimes:png,jpg,jpeg',
            'tag_title' => 'required|unique:staticpages'
        ];

        if ($this->method() == 'PUT') {
            $rules = [
                'image'     => 'nullable|images|mimes:png,jpg,jpeg',
                'tag_title' => 'required|unique:staticpages,tag_title,' . $this->id
            ];
        }

        return $rules;
    }
}
