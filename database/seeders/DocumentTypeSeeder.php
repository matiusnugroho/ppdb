<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentTypes = [
            'ijazah/skl sd sederajat',
            'ijazah/skl TK sederajat',
            'kartu keluarga',
            'sertifikat',
            'nilai rata-rata rapor',
            'akta kelahiran',
            'surat keterangan pindah orang tua',
            'surat keterangan tidak mampu / Kartu PKH',
            'surat pernyataan keabsahan dokumen',
        ];

        foreach ($documentTypes as $type) {
            DocumentType::create([
                'id' => (string) Str::uuid(),
                'label' => $type,
            ]);
        }
    }
}
