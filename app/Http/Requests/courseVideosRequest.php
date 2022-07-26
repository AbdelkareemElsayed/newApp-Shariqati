<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class courseVideosRequest extends FormRequest
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
            'title_ar' => 'required',
            'title_en' => 'required',
            'video' => 'required|mimes:avi,mp4'
        ];

        if (strtolower($this->method()) == 'put') {
            $rules = [
                'video' => 'nullable|mimes:avi,mp4'
            ];
        }
        return $rules;
    }
}
