<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class courseRequest extends FormRequest
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
            'details_*' => 'required',
            'promo_url' => 'nullable|url',
            'image' => 'required|mimes:png,jpg,jpeg',
            'promo_video' => 'nullable|mimes:avi,mp4',
            'points_*' => 'nullable',
            'slug' => 'required|unique:courses'
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
