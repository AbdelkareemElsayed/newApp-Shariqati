<?php

namespace App\Http\Requests\ecommerceModules;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class productsRequest extends FormRequest
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
            'name_*'           => 'required',
            'description_*'    => 'required',
            'price'            => 'required',
            'categories_id'    => 'required|array',
            'manufacturers_id' => 'nullable|numeric',
            'image'            => 'required|image|mimes:png,jpg,jpeg',
            'quantity'         => 'required',
            'is_feature'       => 'nullable',
            'min_order'        => 'required',
            'max_order'        => 'nullable',
            'product_status'   => 'nullable',
            'isFlashe'         => 'nullable',
            'start'            => ['nullable',Rule::requiredIf(request()->isFlashe == true),'date','after_or_equal:today'],
            'end'              => ['nullable',Rule::requiredIf(request()->isFlashe == true),'date','after:start'],
            'type'             => ['nullable',Rule::requiredIf(request()->isFlashe == true)],
            'value'            => ['nullable',Rule::requiredIf(request()->isFlashe == true),'numeric'],
        ];

        if (strtolower($this->method) == 'put') {
            $rules = [
                'image' => 'nullable|image|mimes:png,jpg,jpeg',
            ];
        }
        return $rules;
    }
}
