<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class eventRequest extends FormRequest
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
            'details_*' => 'required',
            'keywords' => 'nullable',
            'image' => 'required|mimes:png,jpg,jpeg',
            'points' => 'required',
            'slug' => 'required|unique:events'
        ];

        if ($this->method() == 'PUT') {
            $rules = [
                'image' => 'nullable|mimes:png,jpg,jpeg',
                'slug' => 'required|unique:events,slug,' . $this->id
            ];
        }

        return $rules;
    }
}
