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
            'password' => 'sometimes|string|min:8',
            'username' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($userId),
            ],
            'nama' => 'sometimes|string|max:255',
            'tempat_lahir' => 'sometimes|string|max:255',
            'tanggal_lahir' => 'sometimes|date',
            'nama_bapak_ibu' => 'sometimes|string|max:255',
            'nik' => [
                'sometimes',
                'string',
                'size:16',
                Rule::unique('students')->ignore($studentId),
            ],
            'no_kk' => [
                'sometimes',
                'string',
                'size:16',
                Rule::unique('students')->ignore($studentId),
            ],
            'no_hp_ortu' => 'sometimes|string|max:15',
            'foto' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
