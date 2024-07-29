<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
    public function messages(): array
    {
        return [
            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa string.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Email sudah digunakan.',

            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa string.',
            'password.min' => 'Password harus memiliki minimal 8 karakter.',

            'username.required' => 'Username wajib diisi.',
            'username.string' => 'Username harus berupa string.',
            'username.max' => 'Username tidak boleh lebih dari 255 karakter.',
            // Validasi untuk field 'nama'
            'nama.sometimes' => 'Nama bersifat opsional, namun harus berupa string dengan panjang maksimum 255 karakter jika disediakan.',
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa string.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            // Validasi untuk field 'tempat_lahir'
            'tempat_lahir.sometimes' => 'Tempat Lahir bersifat opsional, namun harus berupa string dengan panjang maksimum 255 karakter jika disediakan.',
            'tempat_lahir.required' => 'Tempat Lahir wajib diisi.',
            'tempat_lahir.string' => 'Tempat Lahir harus berupa string.',
            'tempat_lahir.max' => 'Tempat Lahir tidak boleh lebih dari 255 karakter.',

            // Validasi untuk field 'tanggal_lahir'
            'tanggal_lahir.sometimes' => 'Tanggal Lahir bersifat opsional, namun harus berupa tanggal yang valid jika disediakan.',
            'tanggal_lahir.required' => 'Tanggal Lahir wajib diisi.',
            'tanggal_lahir.date' => 'Tanggal Lahir harus berupa tanggal yang valid.',

            // Validasi untuk field 'nama_bapak_ibu'
            'nama_bapak_ibu.sometimes' => 'Nama Bapak Ibu bersifat opsional, namun harus berupa string dengan panjang maksimum 255 karakter jika disediakan.',
            'nama_bapak_ibu.required' => 'Nama Bapak Ibu wajib diisi.',
            'nama_bapak_ibu.string' => 'Nama Bapak Ibu harus berupa string.',
            'nama_bapak_ibu.max' => 'Nama Bapak Ibu tidak boleh lebih dari 255 karakter.',

            // Validasi untuk field 'nik'
            'nik.sometimes' => 'NIK bersifat opsional, namun harus berupa string dengan panjang tepat 16 karakter jika disediakan.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.string' => 'NIK harus berupa string.',
            'nik.size' => 'NIK harus terdiri dari tepat 16 karakter.',
            'nik.unique' => 'NIK harus unik.',

            // Validasi untuk field 'no_kk'
            'no_kk.sometimes' => 'No. KK bersifat opsional, namun harus berupa string dengan panjang tepat 16 karakter jika disediakan.',
            'no_kk.required' => 'No. KK wajib diisi.',
            'no_kk.string' => 'No. KK harus berupa string.',
            'no_kk.size' => 'No. KK harus terdiri dari tepat 16 karakter.',
            'no_kk.unique' => 'No. KK harus unik.',

            // Validasi untuk field 'no_hp_ortu'
            'no_hp_ortu.sometimes' => 'No. HP Ortu bersifat opsional, namun harus berupa string dengan panjang maksimum 15 karakter jika disediakan.',
            'no_hp_ortu.required' => 'No. HP Ortu wajib diisi.',
            'no_hp_ortu.string' => 'No. HP Ortu harus berupa string.',
            'no_hp_ortu.max' => 'No. HP Ortu tidak boleh lebih dari 15 karakter.',
        ];
    }
}
