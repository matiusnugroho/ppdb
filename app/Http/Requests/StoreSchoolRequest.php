<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolRequest extends FormRequest
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
            'nama_sekolah' => 'required|string|max:255',
            'nss' => 'required|numeric|digits_between:6,10|unique:schools,nss',
            'jenjang' => 'required|string|max:255',
            'npsn' => 'required|numeric|digits_between:6,10|unique:schools,npsn',
            'alamat' => 'required|string|max:500',
            'no_telp' => 'required|numeric|digits_between:11,15',
            'email' => 'required|email|max:255|unique:users,email',
            'nama_kepsek' => 'required|string|max:255',
            'kecamatan_id' => 'required|numeric|max:255',
            'password' => 'required|string|min:8',
            'username' => 'required|string|max:255|unique:users,username',
        ];
    }
}
