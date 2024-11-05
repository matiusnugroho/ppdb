<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use App\Models\Kecamatan;
use App\Models\RegistrationPeriod;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Symfony\Component\Console\Helper\ProgressBar;

function createUsername($name)
{
    // Convert to lowercase and remove spaces
    $username = Str::of($name)->lower()->replace(' ', '');

    return $username;
}

class UserTestSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $schoolTypes = [
            ['nama' => 'SMP Negeri', 'jenjang' => 'smp'],
            ['nama' => 'SD Negeri', 'jenjang' => 'sd'],
            ['nama' => 'SD', 'jenjang' => 'sd'],
            ['nama' => 'SD Negeri', 'jenjang' => 'sd'],
        ];
        $numberRange = range(1, 15);

        // Ensure the roles exist
        $roleSekolah = Role::firstOrCreate(['name' => 'sekolah']);
        $roleSiswa = Role::firstOrCreate(['name' => 'siswa']);

        $currentYear = Carbon::now()->year;
        $tahunAjaran = $currentYear.'/'.($currentYear + 1);

        $registrationPeriod = RegistrationPeriod::firstOrCreate([
            'tahun_ajaran' => $tahunAjaran,
            'start_date' => Carbon::now()->toDateString(),
            'end_date' => Carbon::now()->addDays(30)->toDateString(),
            'is_open' => true,
        ]);
        $this->command->info('Registration Period created: '.$registrationPeriod->id);

        // Create a user with role 'sekolah'
        /* $userSekolah = User::create([
            'username' => $faker->userName,
            'email' => $faker->unique()->safeEmail,
            'password' => Hash::make('password'), // or use a secure password
        ]);
        $userSekolah->assignRole($roleSekolah); */

        // Create a user with role 'siswa' for testing first data
        $userSiswa = User::create([
            'username' => 'saritri', // You can replace this with static data if needed
            'email' => $faker->unique()->safeEmail,
            'password' => Hash::make('password'), // You can replace 'password' with a secure password if desired
        ]);

        // Assign the 'siswa' role to the user
        $userSiswa->assignRole($roleSiswa);
        Student::create([
            'user_id' => $userSiswa->id,
            'nisn' => $faker->unique()->numerify('######'),
            'nama' => 'Saritri Putri', // Replace this with static data if needed
            'tempat_lahir' => $faker->city,
            'tanggal_lahir' => $faker->date,
            'nama_bapak' => $faker->name('male'),
            'nama_ibu' => $faker->name('female'),
            'nik' => $faker->unique()->numerify('################'),
            'no_kk' => $faker->unique()->numerify('################'),
            'no_hp_ortu' => $faker->phoneNumber,
            'alamat' => $faker->address,
            'kecamatan_id' => 1,
        ]);
        $dataSiswa = [];
        //populate 10 data siswa untuk didaftarkan testing only
        foreach (range(1, 10) as $index) {
            $userSiswa = User::create([
                'username' => $faker->userName, // You can replace this with static data if needed
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'), // You can replace 'password' with a secure password if desired
            ]);

            // Assign the 'siswa' role to the user
            $userSiswa->assignRole($roleSiswa);

            $student = Student::create([
                'user_id' => $userSiswa->id,
                'nisn' => $faker->unique()->numerify('######'),
                'nama' => $faker->name, // Replace this with static data if needed
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date,
                'nama_bapak' => $faker->name('male'),
                'nama_ibu' => $faker->name('female'),
                'nik' => $faker->unique()->numerify('################'),
                'no_kk' => $faker->unique()->numerify('################'),
                'no_hp_ortu' => $faker->phoneNumber,
                'alamat' => $faker->address,
                'kecamatan_id' => $faker->randomElement($numberRange),
            ]);

            $dataSiswa[] = $student;
            $this->command->info('Student created: '.$dataSiswa[$index - 1]->id);
        }
        $kecamatans = Kecamatan::all(); // Get all Kecamatan
        $dataSekolah = [];
        $total = count($kecamatans) * 10;
        $this->command->info('Membuatkan sekolah');
        $progressBar = new ProgressBar($this->command->getOutput(), $total);
        $progressBar->start();
        foreach ($kecamatans as $kecamatan) {
            for ($i = 0; $i < 5; $i++) {
                $schoolType = $faker->randomElement($schoolTypes); // Randomly select SMAN or SMP
                $schoolNumber = $faker->randomElement($numberRange); // Randomly select a number
                $city = $kecamatan->nama; // Random city name
                $schoolName = "{$schoolType['nama']} {$schoolNumber} {$city}";
                $userSekolah = User::create([
                    'username' => createUsername($schoolName),
                    'email' => $faker->unique()->safeEmail,
                    'password' => Hash::make('password'), // or use a secure password
                ]);
                $userSekolah->assignRole($roleSekolah);

                $dataSekolah[] = School::create([
                    'nama_sekolah' => $schoolName,
                    'jenjang' => $schoolType['jenjang'],
                    'nss' => $faker->unique()->numerify('######'),
                    'npsn' => $faker->unique()->numerify('######'),
                    'alamat' => $faker->address,
                    'no_telp' => $faker->phoneNumber,
                    'email' => $faker->unique()->companyEmail,
                    'nama_kepsek' => $faker->name,
                    'kecamatan_id' => $kecamatan->id, // Assign the current Kecamatan
                    'user_id' => $userSekolah->id, // Assuming $userSekolah is already defined
                ]);
                $progressBar->advance();
            }
        }
        $progressBar->finish();
        $this->command->info('Sekolah created: '.count($dataSekolah));
        $sekolahPercontohan = $dataSekolah[0];
        $documentTypes = DocumentType::all();
        //daftarkan siswa ke sekolah percontohan
        $countSiswa = count($dataSiswa);
        $this->command->info("Daftarkan {$countSiswa} siswa ke sekolah percontohan");
        $progressBar = new ProgressBar($this->command->getOutput(), count($dataSiswa));
        $progressBar->start();
        foreach ($dataSiswa as $siswa) {

            $data = [
                'registration_period_id' => $registrationPeriod->id,
                'school_id' => $sekolahPercontohan->id,
                'jenjang' => $sekolahPercontohan->jenjang,
                'registration_number' => generateRegistrationNumber($sekolahPercontohan->jenjang),
                'registration_path_id' => 1,
                'status' => 'pending',
                //'student_id' => $siswa->id, // Make sure to include this
            ];
            // Start by creating the registration for the student
            $siswa->registration()->create($data);

            // Reload the registration relationship to ensure it's available
            $siswa->load('registration');
            $registration = $siswa->registration;

            // Advance the progress bar
            $progressBar->advance();
            foreach ($documentTypes as $documentType) {
                $this->command->info('Creating document for document type: '.$documentType->label);
                $documents = $registration->documents()->create([
                    'document_type_id' => $documentType->id,
                    'status' => 'belum upload',
                ]);
                if ($documents) {
                    $this->command->info('Document created for document type: '.$documentType->label);
                } else {
                    $this->command->error('Document not created for document type: '.$documentType->label);
                }

            }

            // Output success message
            $this->command->info('Registration created for student: '.$siswa->nama.' username: '.$siswa->user->username);

        }
        $progressBar->finish();
        $this->command->info('Sekolah Percontohan adalah : '.$sekolahPercontohan->nama_sekolah.' username : '.$sekolahPercontohan->user->username);

    }
}
