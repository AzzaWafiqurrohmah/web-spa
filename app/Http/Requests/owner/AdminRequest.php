<?php

namespace App\Http\Requests\owner;

use App\Exceptions\Api\FailedValidation;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'name' => 'required',
            'franchise_id' => 'required',
            'email' => 'required',
            'password' => 'nullable',
            'uang_makan' => 'required',
            'biaya_ekstra_malam' => 'required',
            'biaya_transport' => 'required'
        ];

        if($this->getMethod() == 'POST'){
            $rules['password'] = 'required|size:8';
            $rules['email'] = 'required|unique:users,email';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Kolom Nama Lengkap harap diisi',
            'franchise_id.required' => 'Kolom Nama Cabang harap diisi',
            'email.required' => 'Kolom email harap diisi',
            'password.required' => 'Kolom password harap diisi',
            'uang_makan.required' => 'Kolom Biaya Uang Makan harap diisi',
            'biaya_ekstra_malam' => 'Kolom Biaya Ekstra Malam harap diisi',
            'biaya_transport' => 'Kolom Tarif Transportasi harap diisi'
        ];
    }

}
