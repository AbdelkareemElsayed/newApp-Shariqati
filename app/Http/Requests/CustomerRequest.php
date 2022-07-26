<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'name'        => "required|min:2",
            'email'       => "required|email|unique:users",
            'password'    => "required|min:6|max:10",
            "image"       => "required|image|mimes:png,jpg,jpeg",
            "phone"       => "required",
            "country_id"  => "required|numeric",
            'type'        => 'required|numeric',
        ];

        # Update Case . . .
        if ($this->method() == "PUT") {

            $id = (filter_var(request()->path(), FILTER_SANITIZE_NUMBER_INT));

            $rules['email'] = "required|email|min:15|unique:users,email," . $id;
            $rules['image'] =  "nullable|image|mimes:png,jpg";
            $rules['password'] = "nullable|min:6|max:10";
        }

        return $rules;
    }
}
