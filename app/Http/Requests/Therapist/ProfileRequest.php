<?php

namespace App\Http\Requests\Therapist;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest
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
            'image' => 'nullable',
            'email' => 'required|email',
        ];
        $user = Auth::user();
        if($user->hasRole(['admin', 'owner'])){
            $rules['name'] = 'required|string';
            return $rules;
        } else {
            $rules['fullname'] = 'required|string';
            $rules['birth_date'] = 'required|date_format:Y-m-d';
            $rules['gender'] = 'required';
            $rules['address'] = 'required';
            $rules['body_height'] = 'required|int|min:0';
            $rules['body_weight'] = 'required|int|min:0';
            $rules['phone'] = 'required|size:12';
            return $rules;
        }
    }
}
