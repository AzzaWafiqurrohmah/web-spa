<?php

namespace App\Http\Requests\owner;

use Illuminate\Foundation\Http\FormRequest;

class FranchiseRequest extends FormRequest
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
        return [
            'name' => 'required|string',
            'province' => 'required|exists:regions,code',
            'regency' => 'required|exists:regions,code',
            'latitude' => 'required',
            'longitude' => 'required',
        ];
    }
}
