<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
            //
            "name_en"            => "required|min:3",
            "name_ar"            => "required|min:3",
            "email"              => "required|email",
            "location"           => "required|url",
            "facebook"           => "required|url",
            "whatsapp"           => "required",
            "instagram"          => "required|url",
            "linkedin"           => "required|url",
            "twitter"            => "required|url",
            "tiktok"             => "required|url",
            "snapchat"           => "required|url",
            "country_id"         => "required|numeric",
            "city_id"            => "required|numeric",
            "state_id"           => "required|numeric",
            "streetName"         => "required",
            "buildNumber"        => "required",
            "commomPlaces"       => "nullable",
            "address_additional" => "required",
            "phone"              => "required",
        ];
    }
}
