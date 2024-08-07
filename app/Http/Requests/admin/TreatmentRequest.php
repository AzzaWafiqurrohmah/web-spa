<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class TreatmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'treatment_category_id' => 'required',
            'name' => 'required|string',
            'duration' => 'required|int',
            'period_start' => 'required|date_format:Y-m-d',
            'member_price' => 'required|int',
            'price' => 'required|int',
            'discount' => 'required|int',
            'tools' => 'required',
            'materials' => 'required',
            'pictures' => 'nullable'
        ];

        if ($this->isMethod('POST')){
            $rules['pictures'] = 'required';
        }


        return $rules;
    }
}
