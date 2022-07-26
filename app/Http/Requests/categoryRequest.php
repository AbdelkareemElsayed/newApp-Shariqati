<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class categoryRequest extends FormRequest
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
            'name_*' => 'required',
            'description_*' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg',
            'slug' => 'required|unique:categories'
        ];

        if ($this->method() == 'PUT') {
            $rules = [
                'name_en' => 'required',
                'name_ar' => 'required',
                'description_ar' => 'required',
                'description_en' => 'required',
                'image' => 'nullable|mimes:png,jpg,jpeg',
                'slug' => 'required|unique:categories,slug,' . $this->id
            ];
        }

        return $rules;
    }
}
