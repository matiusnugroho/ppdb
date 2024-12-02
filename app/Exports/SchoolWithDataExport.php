<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SchoolWithDataExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $schools;

    private $jalurPendaftaran;

    public function __construct(Collection $schools, Collection $jalurPendaftaran)
    {
        $this->schools = $schools;
        $this->jalurPendaftaran = $jalurPendaftaran;
    }

    public function collection()
    {
        $data = $this->schools->map(function ($school) {
            // Prepare the row data
            $row = [
                'ID' => $school->id,
                'Nama Sekolah' => $school->nama_sekolah,
                'Jenjang' => $school->jenjang,
                'NSS' => $school->nss,
                'NPSN' => $school->npsn,
                'Daya Tampung' => $school->daya_tampung,
                'Kecamatan' => $school->kecamatan->nama ?? null,
            ];

            // Add dynamic columns for each jalur
            foreach ($this->jalurPendaftaran as $jalur) {
                $row[$jalur->name] = $school->path_counts[$jalur->name] ?? 0;
            }

            return $row;
        });

        //dd($data);
        return $data;
    }

    public function headings(): array
    {
        // Static headers
        $headers = [
            'ID',
            'Nama Sekolah',
            'Jenjang',
            'NSS',
            'NPSN',
            'Daya Tampung',
            'Kecamatan',
        ];

        // Dynamic headers based on the jalur pendaftaran
        foreach ($this->jalurPendaftaran as $jalur) {
            $headers[] = $jalur->name;
        }

        return $headers;
    }
}
