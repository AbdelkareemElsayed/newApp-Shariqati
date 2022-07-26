<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class rolesRequest extends FormRequest
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
            'title_en'    => "required|min:2",
            'title_ar'    => "required|min:2",
           
        ];

        # Update Case . . .
        if ($this->method() == "PUT") {

            $id = (filter_var(request()->path(), FILTER_SANITIZE_NUMBER_INT));

            // $rules['email'] = "required|email|min:15|unique:admins,email," . $id;
            // $rules['image'] =  "nullable|image|mimes:png,jpg";
        }
    
        return $rules;
    }
}
