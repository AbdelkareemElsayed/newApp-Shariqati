<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserReport extends FormRequest
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
        return [
                 "from" => "required|date",
                 "to"   => "required|date|after_or_equal:".request()->from
        ];
    }
}
