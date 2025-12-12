<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property string $id
 * @property string $registration_id
 * @property int $path_requirement_id
 * @property string|null $path
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $alasan_reject
 * @property-read string $url_path
 * @property-read \App\Models\PathRequirement $pathRequirement
 * @property-read \App\Models\Registration $registration
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereAlasanReject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document wherePathRequirementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereRegistrationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereUpdatedAt($value)
 */
	class Document extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents
 * @property-read int|null $documents_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DocumentType whereUpdatedAt($value)
 */
	class DocumentType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\School> $schools
 * @property-read int|null $schools_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kecamatan whereUpdatedAt($value)
 */
	class Kecamatan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $registration_path_id
 * @property string $document_type_id
 * @property string|null $jenjang
 * @property bool $is_required
 * @property string|null $allowed_file_types
 * @property int|null $max_file_size
 * @property int $display_order
 * @property array<array-key, mixed>|null $validation_rules
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DocumentType $documentType
 * @property-read \App\Models\RegistrationPath $registrationPath
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PathRequirement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PathRequirement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PathRequirement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PathRequirement whereAllowedFileTypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PathRequirement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PathRequirement whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PathRequirement whereDocumentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PathRequirement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PathRequirement whereIsRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PathRequirement whereJenjang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PathRequirement whereMaxFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PathRequirement whereRegistrationPathId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PathRequirement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PathRequirement whereValidationRules($value)
 */
	class PathRequirement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $student_id
 * @property string $school_id
 * @property string $jenjang
 * @property int $registration_period_id
 * @property string $registration_number
 * @property string $status
 * @property string $kelulusan
 * @property int|null $verified_by
 * @property int $registration_path_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents
 * @property-read int|null $documents_count
 * @property-read \App\Models\RegistrationPath $registrationPath
 * @property-read \App\Models\RegistrationPeriod $registrationPeriod
 * @property-read \App\Models\School $school
 * @property-read \App\Models\Student $student
 * @property-read \App\Models\User|null $verifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration whereJenjang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration whereKelulusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration whereRegistrationPathId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration whereRegistrationPeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration whereVerifiedBy($value)
 */
	class Registration extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $quota_percentage
 * @property bool $is_active
 * @property int $display_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PathRequirement> $requirements
 * @property-read int|null $requirements_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPath newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPath newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPath query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPath whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPath whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPath whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPath whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPath whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPath whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPath whereQuotaPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPath whereUpdatedAt($value)
 */
	class RegistrationPath extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $tahun_ajaran
 * @property string $start_date
 * @property string $end_date
 * @property int $is_open
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPeriod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPeriod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPeriod query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPeriod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPeriod whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPeriod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPeriod whereIsOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPeriod whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPeriod whereTahunAjaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegistrationPeriod whereUpdatedAt($value)
 */
	class RegistrationPeriod extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $nama_sekolah
 * @property string|null $nss
 * @property string|null $npsn
 * @property string $jenjang
 * @property string|null $alamat
 * @property string|null $no_telp
 * @property string|null $email
 * @property string|null $nama_kepsek
 * @property string $kecamatan_id
 * @property int $user_id
 * @property int $daya_tampung
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kecamatan|null $kecamatan
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Registration> $lulusRegistrations
 * @property-read int|null $lulus_registrations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Registration> $registrations
 * @property-read int|null $registrations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property-read int|null $students_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Registration> $tidakLulusRegistrations
 * @property-read int|null $tidak_lulus_registrations_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereDayaTampung($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereJenjang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereKecamatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereNamaKepsek($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereNamaSekolah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereNoTelp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereNpsn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereNss($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereUserId($value)
 */
	class School extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $url_video_tutorial
 * @property string|null $header
 * @property array<array-key, mixed>|null $social_media
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereSocialMedia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereUrlVideoTutorial($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string|null $jenjang
 * @property int|null $nisn
 * @property string $nama
 * @property string|null $jenis_kelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $nama_bapak
 * @property string $nama_ibu
 * @property string $nik
 * @property string $no_kk
 * @property string $no_hp_ortu
 * @property string $alamat
 * @property string|null $foto
 * @property string|null $foto_url
 * @property int $user_id
 * @property int $kecamatan_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $thumbnail_url
 * @property-read \App\Models\Registration|null $registration
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\School> $schools
 * @property-read int|null $schools_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereFotoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereJenjang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereKecamatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereNamaBapak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereNamaIbu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereNik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereNisn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereNoHpOrtu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereNoKk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereTanggalLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereTempatLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereUserId($value)
 */
	class Student extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $username
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $role
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\School|null $school
 * @property-read \App\Models\Student|null $student
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

