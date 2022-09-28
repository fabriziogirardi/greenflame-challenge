<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EditDiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Base, always required
            'name' => [
                'alpha_num',
                'required',
                'min:1',
                'max:30',

                // Verify uniqueness without self checking
                Rule::unique('discounts', 'name')->ignore($this->id, )->where('deleted_at', NULL),
                ],
            'active' => 'boolean',
            'brand_id' => 'required|exists:\App\Models\Brand,id',
            'access_type_code' => 'required|exists:\App\Models\AccessType,code',
            'priority' => 'required|numeric|min:1|max:1000',
            'region_id' => 'required|exists:\App\Models\Region,id',

            // Period 1, always required
            'period_1.from_days' => 'required|numeric',
            'period_1.to_days' => 'required|gt:period_1.from_days',
            'period_1.code' => 'sometimes|alpha_num|nullable|required_if:period_1.discount,null',
            'period_1.discount' => 'sometimes|numeric|nullable|required_if:period_1.code,null',

            // Period 2
            'period_2.from_days' => 'sometimes|numeric|nullable|required_with:period_2.to_days',
            'period_2.to_days' => 'sometimes|gt:period_2.from_days|nullable|required_with:period_2.from_days',
            'period_2.code' => 'sometimes|alpha_num|nullable|required_if:period_2.discount,null',
            'period_2.discount' => 'sometimes|numeric|nullable|required_if:period_2.code,null',

            // Period 3
            'period_3.from_days' => 'sometimes|numeric',
            'period_3.to_days' => 'sometimes|gt:period_3.from_days',
            'period_3.code' => 'sometimes|alpha_num|nullable|required_if:period_3.discount,null',
            'period_3.discount' => 'sometimes|numeric|nullable|required_if:period_3.code,null',

            // Dates, always required
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start',
        ];
    }
}
