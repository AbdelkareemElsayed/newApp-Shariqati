<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class teamMemberRequest extends FormRequest
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
            'image' => 'required|mimes:png,jpg,jpeg',
            'social_*' => 'nullable',
            'about_*' => 'required',
            'facebook_link' => 'nullable',
            'twitter_link' => 'nullable',
            'linkedin_link' => 'nullable',
            'youtube_link' => 'nullable',
        ];

        if (strtolower($this->method()) == 'put') {
            $rules = ['image' => 'nullable|mimes:png,jpg,jpeg'];
        }
        return $rules;
    }
}
