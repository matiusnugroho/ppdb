<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateStudentRequest extends StudentRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'nik' => trim($this->input('nik')),
            'no_kk' => trim($this->input('no_kk')),
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $studentId = auth()->user()->student->id;
        $userId = auth()->user()->id;

        return [
            'email' => [
                'sometimes',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId),
            ],
            'password' => 'sometimes|required|string|min:8',
            'username' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($userId),
            ],
            'nisn' => 'sometimes|required|numeric',
            'nama' => 'sometimes|required|string|max:255|regex:/^[a-zA-Z\s,\'-]+$/',
            'tempat_lahir' => 'sometimes|required|string|max:255',
            'tanggal_lahir' => 'sometimes|required|date',
            'nama_bapak' => 'sometimes|required|string|max:255',
            'nama_ibu' => 'sometimes|required|string|max:255',
            'nik' => [
                'sometimes',
                'required',
                'numeric',
                'digits:16',
                Rule::unique('students')->ignore($studentId),
            ],
            'no_kk' => [
                'sometimes',
                'numeric',
                'required',
                'digits:16',
                Rule::unique('students')->ignore($studentId),
            ],
            'no_hp_ortu' => 'sometimes|required|string|max:15',
            'foto' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
