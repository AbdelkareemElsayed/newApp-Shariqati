<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class sliderRequest extends FormRequest
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
            'title' => 'nullable',
            'image' => 'required|mimes:png,jpg,jpeg',
            'alt_text' => 'nullable'
        ];

        if ($this->method() == 'PUT') {
            $rules = [
                'title' => 'nullable',
                'image' => 'nullable|mimes:png,jpg,jpeg',
                'alt_text' => 'nullable',
                'slug' => 'required|unique:slides,id,' . $this->id
            ];
        }

        return $rules;
    }
}
