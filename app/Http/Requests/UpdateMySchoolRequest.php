<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMySchoolRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('edit_my_profile_sekolah') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $schoolId = $this->user()?->school?->id;
        $userId = $this->user()?->id;

        return [
            'nama_sekolah' => ['required', 'string', 'max:255'],
            'nss' => [
                'nullable',
                'numeric',
                'digits_between:6,10',
                Rule::unique('schools', 'nss')->ignore($schoolId, 'id'),
            ],
            'jenjang' => ['required', 'string', 'max:255'],
            'npsn' => [
                'nullable',
                'numeric',
                'digits_between:6,10',
                Rule::unique('schools', 'npsn')->ignore($schoolId, 'id'),
            ],
            'alamat' => ['required', 'string', 'max:500'],
            'no_telp' => ['nullable', 'numeric', 'digits_between:11,15'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('schools', 'email')->ignore($schoolId, 'id'),
                Rule::unique('users', 'email')->ignore($userId, 'id'),
            ],
            'nama_kepsek' => ['required', 'string', 'max:255'],
            'kecamatan_id' => ['required', 'numeric'],
            'daya_tampung' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
