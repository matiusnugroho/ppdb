<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pendaftaran\StoreDaftarRequest;
use App\Http\Requests\RevisiDokumenRequest;
use App\Http\Requests\StoreRegistrationPeriodRequest;
use App\Http\Requests\UploadDokumenRequest;
use App\Models\Document;
use App\Models\Registration;
use App\Models\RegistrationPath;
use App\Models\RegistrationPeriod;
use App\Models\School;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Storage;
use Str;

class PendaftaranController extends Controller
{
    public function getOpenPeriods()
    {
        $openPeriods = RegistrationPeriod::where('is_open', true)->get();

        return response()->json(
            $openPeriods
        );
    }

    public function isTodayOpened()
    {
        $today = Carbon::today();
        $openPeriods = RegistrationPeriod::where('is_open', true)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->get();

        // Check if there are any periods open today
        $isPeriodOpenToday = $openPeriods->isNotEmpty();

        return response()->json($isPeriodOpenToday);
    }

    //Buka pendaftaran tahun ajaran baru
    public function bukaPendaftaran(StoreRegistrationPeriodRequest $request)
    {
        if (! $request->user()->can('create_registration_period')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }
        // Update previous periods and create new period
        RegistrationPeriod::where('is_open', true)->update(['is_open' => false]);
        $data = $request->validated();
        $data['is_open'] = true;
        $period = RegistrationPeriod::create($data);

        return response()->json($period);
    }

    //daftar siswa ke sekolah
    public function daftar(StoreDaftarRequest $request)
    {
        if (! $request->user()->can('daftar_siswa')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }
        $data = $request->validated();

        $school = School::find($data['school_id']);
        $dayaTampungSekolah = $school->daya_tampung;
        $jalurPendaftaran = RegistrationPath::find($data['registration_path_id']);
        $quota_percentage_of_jalur = $jalurPendaftaran->quota_percentage;
        $quota = ceil($dayaTampungSekolah * $quota_percentage_of_jalur / 100);
        
        $currentRegistationOfJalur =  $school->activeCountByJalur($data['registration_path_id']);
        
        if ($currentRegistationOfJalur >= $quota) {
            return response()->json([
                'message' => 'Daya Tampung Sekolah '.$school->name.' untuk jalur '.$jalurPendaftaran->name.' sudah mencapai batas quota. Silahkan pilih jalur atau sekolah lain',
            ], 400);
        }


        
        $registrationPeriod = RegistrationPeriod::where('is_open', true)->first();
        $data['registration_period_id'] = $registrationPeriod->id;
        $data['registration_number'] = $this->generateRegistrationNumber($data['jenjang']);
        //dd($data);
        $student = $request->user()->student;
        $existingRegistration = Registration::where('student_id', $student->id)->first();

        if ($existingRegistration) {
            return response()->json([
                'message' => 'Anda tidak boleh mendaftar ke lebih satu sekolah.',
            ], 400);
        }
        $student->registration()->create($data);
        $jalur = RegistrationPath::find($data['registration_path_id']);
        $requirements = $jalur->requirements()->where('jenjang', auth()->user()->student->jenjang)->get();
        foreach ($requirements as $requirement) {
            $student->registration->documents()->create([
                'path_requirement_id' => $requirement->id,
                'status' => 'belum upload',
            ]);
        }
        $registration = $student->registration;
        $registration->load('school', 'documents');

        return response()->json([
            'success' => true,
            'data' => $student->registration,
        ]);
    }

    public function uploadDokumen(UploadDokumenRequest $request, Document $document)
    {
        if (! $request->user()->can('upload_document_siswa')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }
        $registration = $document->registration;
        if ($registration->student_id !== $request->user()->student->id) {
            return response()->json([
                'message' => 'Anda mengaupload ke pendaftaran yang bukan milik anda.',
            ], 403);
        }
        if ($document->status === 'diverifikasi') {
            return response()->json([
                'message' => 'Dokumen ini sudah diverifikasi.',
            ], 403);
        }
        $data = $request->validated();
        $documentFile = $request->file('file');
        $documentType = str_replace(['/', '\\'], '_', Str::snake($document->documentType->label));
        $extension = $documentFile->getClientOriginalExtension();
        $filename = "{$documentType}.{$extension}";

        $path = $documentFile->storeAs('uploads/registration/dokumen/'.$registration->id, $filename, 'public');
        $document->update(['path' => $path, 'status' => 'menunggu verifikasi']);

        return response()->json([
            'success' => true,
            'url' => asset(Storage::url($path)),
            'data' => $document,
        ]);
    }

    public function revisiDokumen(RevisiDokumenRequest $request, Document $document)
    {
        // Check authorization
        if (! $request->user()->can('upload_document_siswa')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        // Validate the uploaded file
        $data = $request->validated();

        // Check if a new document is provided
        if ($request->hasFile('file')) {
            $oldPath = $document->path;
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            // Store the new document
            $document_file = $request->file('file');
            $label = $document->documentType->label;
            $documentType = str_replace(['/', '\\'], '_', Str::snake($label));
            $extension = $document_file->getClientOriginalExtension();
            $filename = "{$documentType}.{$extension}";
            $registration = $document->registration;

            $path = $document_file->storeAs('uploads/registration/dokumen/'.$registration->id.'/', $filename, 'public');
            $data['path'] = $path;
            $document->update(['path' => $path, 'status' => 'menunggu verifikasi']);

            return response()->json([
                'success' => true,
                'message' => 'Document updated successfully.',
                'data' => $document,
            ]);
        }

        return response()->json([
            'message' => 'No document uploaded.',
        ], 400);
    }

    private function generateRegistrationNumber(string $jenjang)
    {
        // Query the last registration number for the same jenjang
        $lastRegistration = Registration::where('registration_number', 'like', "$jenjang%")
            ->orderBy('registration_number', 'desc')
            ->first();

        // If a registration exists, extract and increment the numeric part
        if ($lastRegistration) {
            // Extract the numeric part from the registration number
            $lastNumber = (int) substr($lastRegistration->registration_number, strlen($jenjang));

            // Increment the last number
            $newNumber = $lastNumber + 1;
        } else {
            // If no previous registration exists for this jenjang, start at 1
            $newNumber = 1;
        }

        // Return the new registration number in the format jenjang000001
        return $jenjang.str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }

    //cek pendaftaran di siswa
    public function cekPendaftaran()
    {
        $registration = Registration::with('school', 'documents')->where('student_id', auth()->user()->student->id)->first();
        $registrationPeriod = RegistrationPeriod::where('is_open', true)->first();
        if (! $registrationPeriod) {
            return response()->json([
                'success' => false,
                'message' => 'Belum ada pendaftaran',
            ], 200);
        }

        return response()->json([
            'success' => true,
            'registration' => $registration,
        ]);
    }

    public function dokumen()
    {
        if (! auth()->user()->can('upload_document_siswa')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $registration = Registration::where('student_id', auth()->user()->student->id)->first();
        $documents = $registration->documents;
        $documents->load('pathRequirement.documentType');

        return response()->json(
            $documents);
    }

    //ambil data pendaftar dari sekolah
    public function getPendaftarSekolah()
    {
        if (! auth()->user()->can('lihat_pendaftar')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }
        $registrationPeriod = RegistrationPeriod::where('is_open', true)->first();
        $school = auth()->user()->school;
        $pendaftar = Registration::with('student', 'verifiedBy')->where('school_id', $school->id)->latest('created_at')->get();
        $totalPendaftar = $pendaftar->count();

        return response()->json([
            'data' => $pendaftar,
            'total' => $totalPendaftar,
        ]);
    }

    public function getPendaftarVerifiedByMe()
    {
        if (! auth()->user()->can('lihat_pendaftar')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }
        $registrationPeriod = RegistrationPeriod::where('is_open', true)->first();
        $verifier = auth()->user()->id;
        $pendaftar = Registration::with('student', 'verifiedBy')->where('verified_by', $verifier)->latest('created_at')->get();
        $totalPendaftar = $pendaftar->count();

        return response()->json([
            'data' => $pendaftar,
            'total' => $totalPendaftar,
        ]);
    }

    public function verifikasi(Request $request)
    {
        //dd(auth()->user()->can('verifikasi_siswa'));
        if (! auth()->user()->can('verifikasi_siswa')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $data = $request->validate([
            'id' => 'required',
        ]);
        $registration = Registration::find($data['id']);
        if (! $registration) {
            return response()->json([
                'message' => 'Data pendaftaran tidak ditemukan',
            ], 404);
        }
        if ($registration->verifiedBy) {
            return response()->json([
                'message' => 'Data pendaftaran sudah diverifikasi oleh '.$registration->verifiedBy->username,
            ], 400);
        }

        $updated = $registration->update(['status' => 'diverifikasi', 'verified_by' => auth()->user()->id]);
        $registration->load('verifiedBy');

        return response()->json([
            'success' => true,
            'message' => 'Data pendaftaran berhasil diverifikasi',
            'data' => $registration,
        ]);
    }

    public function detail(Registration $registration)
    {
        if (! auth()->user()->can('lihat_pendaftar')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (! $registration) {
            return response()->json(['message' => 'Data pendaftaran tidak ditemukan'], 404);
        }

        if ($registration->verified_by !== auth()->user()->id) {
            return response()->json(['message' => 'Anda tidak berhak mengakses data pendaftaran ini'], 403);
        }
        $registration->load('student', 'documents.pathRequirement.documentType', 'verifiedBy');

        return response()->json([
            'success' => true,
            'data' => $registration,
        ]);
    }

    public function verifikasiDokumen(Request $request, Document $document)
    {
        if (! auth()->user()->can('verifikasi_dokumen_siswa')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }
        $document->status = 'diverifikasi';
        $document->save();

        return response()->json([
            'success' => true,
            'data' => $document,
        ]);
    }

    public function rejectDokumen(Request $request, Document $document)
    {
        if (! auth()->user()->can('reject_dokumen_siswa')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }
        $validated = $request->validate([
            'alasan' => 'required|string|max:255',
        ]);
        $document->status = 'ditolak';
        $document->alasan = $validated['alasan'];
        $document->save();

        return response()->json([
            'success' => true,
            'data' => $document,
        ]);
    }

    public function luluskan(Request $request, Registration $registration)
    {
        if (! auth()->user()->can('luluskan_siswa')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }
        $data = $request->validate([
            'kelulusan' => 'required|in:lulus,tidak_lulus',
        ]);
        $registration->update($data);
        $registration->save();

        return response()->json([
            'success' => true,
            'data' => $registration,
        ]);
    }
}
