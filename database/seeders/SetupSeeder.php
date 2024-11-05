<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RegistrationPath;
use App\Models\DocumentType;
use App\Models\PathRequirement;
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
            RegistrationPath::create($path);
        }
        $zonasi = RegistrationPath::where('name', 'zonasi')->first();
        $afirmasi = RegistrationPath::where('name', 'afirmasi')->first();
        $prestasi = RegistrationPath::where('name', 'prestasi')->first();
        $orangTua = RegistrationPath::where('name', 'orang tua')->first();
        $requirements = [
            // Zonasi Path Requirements
            [
                'path' => $zonasi,
                'documents' => [
                    'ijazah/skl smp sederajat' => [
                        'is_required' => true,
                        'display_order' => 1,
                        'jenjang' => 'smp'
                    ],
                    'ijazah/skl TK sederajat' => [
                        'is_required' => false,
                        'display_order' => 1,
                        'jenjang' => 'sd'
                    ],
                    'kartu keluarga' => [
                        'is_required' => true,
                        'display_order' => 2,
                        'jenjang' => 'sd'
                    ],
                    'kartu keluarga' => [
                        'is_required' => true,
                        'display_order' => 2,
                        'jenjang' => 'smp'
                    ],
                    'akta kelahiran' => [
                        'is_required' => true,
                        'display_order' => 3,
                        'jenjang' => 'sd'
                    ],
                    'akta kelahiran' => [
                        'is_required' => true,
                        'display_order' => 3,
                        'jenjang' => 'smp'
                    ],
                    'surat pernyataan keabsahan dokumen' => [
                        'is_required' => true,
                        'display_order' => 4,
                        'jenjang' => 'sd'
                    ],
                    'surat pernyataan keabsahan dokumen' => [
                        'is_required' => true,
                        'display_order' => 4,
                        'jenjang' => 'smp'
                    ],
                ],
            ],
            
            // Afirmasi Path Requirements
            [
                'path' => $afirmasi,
                'documents' => [
                    'ijazah/skl smp sederajat' => [
                        'is_required' => true,
                        'display_order' => 1,
                        'jenjang' => 'smp'
                    ],
                    'ijazah/skl TK sederajat' => [
                        'is_required' => false,
                        'display_order' => 1,
                        'jenjang' => 'sd'
                    ],
                    'kartu keluarga' => [
                        'is_required' => true,
                        'display_order' => 2,
                        'jenjang' => 'sd'
                    ],
                    'kartu keluarga' => [
                        'is_required' => true,
                        'display_order' => 2,
                        'jenjang' => 'smp'
                    ],
                    'akta kelahiran' => [
                        'is_required' => true,
                        'display_order' => 3,
                        'jenjang' => 'sd'
                    ],
                    'akta kelahiran' => [
                        'is_required' => true,
                        'display_order' => 3,
                        'jenjang' => 'smp'
                    ],
                    'surat keterangan tidak mampu / Kartu PKH' => [
                        'is_required' => true,
                        'display_order' => 4,
                        'jenjang' => 'sd'
                    ],
                    'surat keterangan tidak mampu / Kartu PKH' => [
                        'is_required' => true,
                        'display_order' => 4,
                        'jenjang' => 'smp'
                    ],
                    'surat pernyataan keabsahan dokumen' => [
                        'is_required' => true,
                        'display_order' => 5,
                        'jenjang' => 'sd'
                    ],
                    'surat pernyataan keabsahan dokumen' => [
                        'is_required' => true,
                        'display_order' => 5,
                        'jenjang' => 'smp'
                    ],
                ],
            ],
            
            // Prestasi Path Requirements
            [
                'path' => $prestasi,
                'documents' => [
                    'ijazah/skl smp sederajat' => [
                        'is_required' => true,
                        'display_order' => 1,
                        'jenjang' => 'smp'
                    ],
                    'ijazah/skl TK sederajat' => [
                        'is_required' => false,
                        'display_order' => 1,
                        'jenjang' => 'sd'
                    ],
                    'kartu keluarga' => [
                        'is_required' => true,
                        'display_order' => 2,
                        'jenjang' => 'sd'
                    ],
                    'kartu keluarga' => [
                        'is_required' => true,
                        'display_order' => 2,
                        'jenjang' => 'smp'
                    ],
                    'akta kelahiran' => [
                        'is_required' => true,
                        'display_order' => 3,
                        'jenjang' => 'sd'
                    ],
                    'akta kelahiran' => [
                        'is_required' => true,
                        'display_order' => 3,
                        'jenjang' => 'smp'
                    ],
                    'sertifikat' => [
                        'is_required' => true,
                        'display_order' => 4,
                        'jenjang' => 'sd'
                    ],
                    'sertifikat' => [
                        'is_required' => true,
                        'display_order' => 4,
                        'jenjang' => 'smp'
                    ],
                    'surat pernyataan keabsahan dokumen' => [
                        'is_required' => true,
                        'display_order' => 4,
                        'jenjang' => 'sd'
                    ],
                    'surat pernyataan keabsahan dokumen' => [
                        'is_required' => true,
                        'display_order' => 4,
                        'jenjang' => 'smp'
                    ],
                ],
            ],

            // Orang Tua Path Requirements
            [
                'path' => $orangTua,
                'documents' => [
                    'ijazah/skl smp sederajat' => [
                        'is_required' => true,
                        'display_order' => 1,
                        'jenjang' => 'smp'
                    ],
                    'ijazah/skl TK sederajat' => [
                        'is_required' => false,
                        'display_order' => 1,
                        'jenjang' => 'sd'
                    ],
                    'kartu keluarga' => [
                        'is_required' => true,
                        'display_order' => 2,
                        'jenjang' => 'sd'
                    ],
                    'kartu keluarga' => [
                        'is_required' => true,
                        'display_order' => 2,
                        'jenjang' => 'smp'
                    ],
                    'akta kelahiran' => [
                        'is_required' => true,
                        'display_order' => 3,
                        'jenjang' => 'sd'
                    ],
                    'akta kelahiran' => [
                        'is_required' => true,
                        'display_order' => 3,
                        'jenjang' => 'smp'
                    ],
                    'surat keterangan pindah orang tua' => [
                        'is_required' => true,
                        'display_order' => 4,
                        'jenjang' => 'sd'
                    ],
                    'surat keterangan pindah orang tua' => [
                        'is_required' => true,
                        'display_order' => 4,
                        'jenjang' => 'smp'
                    ],
                    'surat pernyataan keabsahan dokumen' => [
                        'is_required' => true,
                        'display_order' => 4,
                        'jenjang' => 'sd'
                    ],
                    'surat pernyataan keabsahan dokumen' => [
                        'is_required' => true,
                        'display_order' => 4,
                        'jenjang' => 'smp'
                    ],
                ],
            ],
        ];

        // Create requirements
        foreach ($requirements as $pathConfig) {
            foreach ($pathConfig['documents'] as $documentLabel => $config) {
                // Find the document type
                $documentType = DocumentType::where('label', $documentLabel)->first();
                
                if ($documentType) {
                    PathRequirement::create([
                        'registration_path_id' => $pathConfig['path']->id,
                        'jenjang' => $config['jenjang'],
                        'document_type_id' => $documentType->id,
                        'is_required' => $config['is_required'],
                        'display_order' => $config['display_order'],
                        'allowed_file_types' => 'pdf',
                        'max_file_size' => 2048,
                    ]);
                }
            }
        }
    }
}
