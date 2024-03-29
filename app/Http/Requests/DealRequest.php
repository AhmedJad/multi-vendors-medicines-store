<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealRequest extends FormRequest
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
            "end_at"=>"required",
            "deals" => "required|array|min:1",
            "deals.*.product_id" => "required",
            "deals.*.supplier_id" => "required",
            "deals.*.client_discount" => "required",
        ];
    }
}
