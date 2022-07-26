<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class blogRequest extends FormRequest
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
            'title_*' => 'required',
            'content_*' => 'required',
            'keywords' => 'nullable',
            'image' => 'required|mimes:png,jpg,jpeg',
            'category_id' => 'required',
            'slug' => 'required|unique:blogs'
        ];

        if ($this->method() == 'PUT') {
            $rules = [
                'title_*' => 'required',
                'title_*' => 'required',
                'keywords' => 'nullable',
                'image' => 'nullable|mimes:png,jpg,jpeg',
                'category_id' => 'required',
                'slug' => 'required|unique:blogs,slug,' . $this->id
            ];
        }

        return $rules;
    }
}
