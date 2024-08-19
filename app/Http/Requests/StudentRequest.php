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
    /* public function messages(): array
    {
        return [
            '*.required' => ':attribute wajib diisi.',
            '*.string' => ':attribute harus berupa string.',
            '*.numeric' => ':attribute harus berupa angka.',
            '*.unique' => ':attribute sudah digunakan.',
            
            
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Email sudah digunakan.',

            
            'password.string' => 'Password harus berupa string.',
            'password.min' => 'Password harus memiliki minimal 8 karakter.',

            
            
            'username.max' => 'Username tidak boleh lebih dari 255 karakter.',
            // Validasi untuk field 'nama'
            'nama.regex' => 'Nama hanya boleh berisi huruf, spasi, dan tanda petik (\').',
            'nama.sometimes' => 'Nama bersifat opsional, namun harus berupa string dengan panjang maksimum 255 karakter jika disediakan.',
            
            
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            // Validasi untuk field 'tempat_lahir'
            'tempat_lahir.sometimes' => 'Tempat Lahir bersifat opsional, namun harus berupa string dengan panjang maksimum 255 karakter jika disediakan.',
            
            
            'tempat_lahir.max' => 'Tempat Lahir tidak boleh lebih dari 255 karakter.',

            // Validasi untuk field 'tanggal_lahir'
            'tanggal_lahir.sometimes' => 'Tanggal Lahir bersifat opsional, namun harus berupa tanggal yang valid jika disediakan.',
            
            'tanggal_lahir.date' => 'Tanggal Lahir harus berupa tanggal yang valid.',

            // Validasi untuk field 'nama_bapak_ibu'
            'nama_bapak.sometimes' => 'Nama Bapak Ibu bersifat opsional, namun harus berupa string dengan panjang maksimum 255 karakter jika disediakan.',
            
            'nama_bapak.max' => 'Nama Bapak Ibu tidak boleh lebih dari 255 karakter.',
            'nama_ibu.sometimes' => 'Nama Ibu bersifat opsional, namun harus berupa string dengan panjang maksimum 255 karakter jika disediakan.',
            'nama_ibu.max' => 'Nama Ibu tidak boleh lebih dari 255 karakter.',

            // Validasi untuk field 'nik'
            'nik.sometimes' => 'NIK bersifat opsional, namun harus berupa string dengan panjang tepat 16 karakter jika disediakan.',
            'nik.size' => 'NIK harus terdiri dari tepat 16 karakter.',
            'nik.unique' => 'NIK harus unik.',

            // Validasi untuk field 'no_kk'
            'no_kk.sometimes' => 'No. KK bersifat opsional, namun harus berupa string dengan panjang tepat 16 karakter jika disediakan.',
            'no_kk.required' => 'No. KK wajib diisi.',
            'no_kk.string' => 'No. KK harus berupa string.',
            'no_kk.size' => 'No. KK harus terdiri dari tepat 16 karakter.',
            'no_kk.unique' => 'No. KK sudah digunakan.',

            // Validasi untuk field 'no_hp_ortu'
            'no_hp_ortu.sometimes' => 'No. HP Ortu bersifat opsional, namun harus berupa string dengan panjang maksimum 15 karakter jika disediakan.',
            'no_hp_ortu.max' => 'No. HP Ortu tidak boleh lebih dari 15 karakter.',
        ];
    } */
}
