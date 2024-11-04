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
                    ],
                    'akta kelahiran' => [
                        'is_required' => true,
                        'display_order' => 2,
                    ],
                    'surat pernyataan keabsahan dokumen' => [
                        'is_required' => true,
                        'display_order' => 3,
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
                    ],
                    'akta kelahiran' => [
                        'is_required' => true,
                        'display_order' => 2,
                    ],
                    'surat pernyataan keabsahan dokumen' => [
                        'is_required' => true,
                        'display_order' => 3,
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
                    ],
                    'nilai rata-rata rapor' => [
                        'is_required' => true,
                        'display_order' => 2,
                    ],
                    'akta kelahiran' => [
                        'is_required' => true,
                        'display_order' => 3,
                    ],
                    'surat pernyataan keabsahan dokumen' => [
                        'is_required' => true,
                        'display_order' => 4,
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
                    ],
                    'akta kelahiran' => [
                        'is_required' => true,
                        'display_order' => 2,
                    ],
                    'surat pernyataan keabsahan dokumen' => [
                        'is_required' => true,
                        'display_order' => 3,
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
