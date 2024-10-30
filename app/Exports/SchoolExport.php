<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SchoolExport implements FromCollection, WithHeadings
{
    protected $schools;

    public function __construct($schools)
    {
        $this->schools = $schools;
    }

    public function collection()
    {
        return $this->schools->map(function ($school) {
            return [
                'ID' => $school->id,
                'Nama Sekolah' => $school->nama_sekolah,
                'NSS' => $school->nss,
                'NPSN' => $school->npsn,
                'Jenjang' => $school->jenjang,
                'Alamat' => $school->alamat,
                'No Telp' => $school->no_telp,
                'Email' => $school->email,
                'Nama Kepsek' => $school->nama_kepsek,
                'Kecamatan ID' => $school->kecamatan_id,
                'Kecamatan' => $school->kecamatan->nama ?? 'N/A',
                'User ID' => $school->user_id,
                'Created At' => $school->created_at,
                'Updated At' => $school->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Sekolah',
            'NSS',
            'NPSN',
            'Jenjang',
            'Alamat',
            'No Telp',
            'Email',
            'Nama Kepsek',
            'Kecamatan ID',
            'Kecamatan',
            'User ID',
            'Created At',
            'Updated At',
        ];
    }
}
