<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorequestionnaireRequest extends FormRequest
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
            'title' => "required|string|max:150|min:4|unique:questionnaires,title",
            'selectedExpiryDate' => 'required|date|after:today',
        ];
    }

    public function attributes(): array
    {
        return [
            'selectedExpiryDate' => 'expiry date',
        ];
    }
}
