<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

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
    public function rules(Request $request): array
    {
        if ($request->id > 0) {
            //update case
            return [
                'id' => "required|integer|exists:questionnaires,id",
                'title' => "required|string|max:150|min:4|unique:questionnaires,title," . $request->id,
                'selectedExpiryDate' => 'required|date|after:today',
            ];
        } else {
            return [
                'title' => "required|string|max:150|min:4|unique:questionnaires,title," . $request->title,
                'selectedExpiryDate' => 'required|date|after:today',
            ];
        }
    }

    public function attributes(): array
    {
        return [
            'selectedExpiryDate' => 'expiry date',
        ];
    }
}
