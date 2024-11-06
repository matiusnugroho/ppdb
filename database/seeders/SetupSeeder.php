<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use App\Models\PathRequirement;
use App\Models\RegistrationPath;
use Illuminate\Database\Seeder;

class SetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paths = [
            [
                'name' => 'zonasi',
                'description' => 'Pendaftaran berdasarkan zona tempat tinggal',
                'quota_percentage' => 70,
                'is_active' => true,
                'display_order' => 1,
            ],
            [
                'name' => 'afirmasi',
                'description' => 'Pendaftaran jalur afirmasi untuk siswa tidak mampu',
                'quota_percentage' => 15,
                'is_active' => true,
                'display_order' => 2,
            ],
            [
                'name' => 'prestasi',
                'description' => 'Pendaftaran jalur prestasi akademik dan non-akademik',
                'quota_percentage' => 10,
                'is_active' => true,
                'display_order' => 3,
            ],
            [
                'name' => 'orang tua',
                'description' => 'Pendaftaran jalur orang tua',
                'quota_percentage' => 5,
                'is_active' => true,
                'display_order' => 4,
            ],
        ];

        foreach ($paths as $path) {
            $registrationPath = RegistrationPath::create($path);
            $this->insertPathRequirements($registrationPath);
        }
    }

    private function insertPathRequirements(RegistrationPath $registrationPath)
    {
        $requirements = [
            'zonasi' => [
                'ijazah/skl sd sederajat' => ['smp' => true],
                'ijazah/skl TK sederajat' => ['sd' => false],
                'nilai rata-rata rapor' => ['sd' => true, 'smp' => true],
                'kartu keluarga' => ['sd' => true, 'smp' => true],
                'akta kelahiran' => ['sd' => true, 'smp' => true],
                'surat pernyataan keabsahan dokumen' => ['sd' => true, 'smp' => true],
            ],
            'afirmasi' => [
                'ijazah/skl sd sederajat' => ['smp' => true],
                'ijazah/skl TK sederajat' => ['sd' => false],
                'nilai rata-rata rapor' => ['sd' => true, 'smp' => true],
                'kartu keluarga' => ['sd' => true, 'smp' => true],
                'akta kelahiran' => ['sd' => true, 'smp' => true],
                'surat keterangan tidak mampu / Kartu PKH' => ['sd' => true, 'smp' => true],
                'surat pernyataan keabsahan dokumen' => ['sd' => true, 'smp' => true],
            ],
            'prestasi' => [
                'ijazah/skl sd sederajat' => ['smp' => true],
                'ijazah/skl TK sederajat' => ['sd' => false],
                'nilai rata-rata rapor' => ['sd' => true, 'smp' => true],
                'kartu keluarga' => ['sd' => true, 'smp' => true],
                'akta kelahiran' => ['sd' => true, 'smp' => true],
                'sertifikat' => ['sd' => true, 'smp' => true],
                'surat pernyataan keabsahan dokumen' => ['sd' => true, 'smp' => true],
            ],
            'orang tua' => [
                'ijazah/skl sd sederajat' => ['smp' => true],
                'ijazah/skl TK sederajat' => ['sd' => false],
                'nilai rata-rata rapor' => ['sd' => true, 'smp' => true],
                'kartu keluarga' => ['sd' => true, 'smp' => true],
                'akta kelahiran' => ['sd' => true, 'smp' => true],
                'surat keterangan pindah orang tua' => ['sd' => true, 'smp' => true],
                'surat pernyataan keabsahan dokumen' => ['sd' => true, 'smp' => true],
            ],
        ];

        foreach ($requirements[$registrationPath->name] as $label => $jenjangConfig) {
            $documentType = DocumentType::firstOrCreate(['label' => $label]);

            foreach ($jenjangConfig as $level => $isRequired) {
                PathRequirement::create([
                    'registration_path_id' => $registrationPath->id,
                    'jenjang' => $level,
                    'document_type_id' => $documentType->id,
                    'is_required' => $isRequired,
                    'display_order' => 1, // Assuming unique IDs for DocumentType
                    'allowed_file_types' => 'pdf',
                    'max_file_size' => 2048,
                ]);
            }
        }
    }
}
