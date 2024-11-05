<?php

namespace App\Http\Requests\Siswa;

use Illuminate\Validation\Rule;

class StoreStudentRequest extends StudentRequest
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
        $studentId = $this->input('id');

        return [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'username' => 'required|string|max:255|unique:users',
            'nama' => 'required|string|max:255|regex:/^[a-zA-Z\s,\'-]+$/',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nama_bapak' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'nisn' => 'nullable|numeric|unique:students',
            'nik' => [
                'required',
                'numeric',
                'digits:16',
                Rule::unique('students')->ignore($studentId),
            ],
            'no_kk' => [
                'required',
                'numeric',
                'digits:16',
                Rule::unique('students')->ignore($studentId),
            ],
            'no_hp_ortu' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
            'kecamatan_id' => 'required|numeric',
            'jenjang' => 'required|string|max:4',
            'jenis_kelamin' => 'required|string|max:2',
        ];
    }
}
