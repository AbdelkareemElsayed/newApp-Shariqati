<?php

namespace App\Http\Requests\ecommerceModules;

use Illuminate\Foundation\Http\FormRequest;

class ManufactureRequest extends FormRequest
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
            'name'    => 'required',
            'image'   => 'required|mimes:png,jpg,jpeg',
            'slug'    => 'required|unique:manufacturers'
        ];

        if ($this->method() == 'PUT') {
            $rules = [
                'image' => 'nullable|mimes:png,jpg,jpeg',
                'slug' => 'required|unique:manufacturers,slug,' . $this->id
            ];
        }

        return $rules;
    }
}
