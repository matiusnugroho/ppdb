<?php

namespace App\Http\Requests\Jalur;

use Illuminate\Foundation\Http\FormRequest;

class CreateJalurRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->role === 'super_admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'quota_percentage' => 'required|numeric|min:0|max:100',
        ];
    }
}
