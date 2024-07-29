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
            'ijazah/skl smp sederajat',
            'nilai rata-rata rapor',
            'akta kelahiran',
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
