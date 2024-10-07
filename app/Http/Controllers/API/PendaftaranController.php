<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RevisiDokumenRequest;
use App\Http\Requests\StoreDaftarRequest;
use App\Http\Requests\StoreRegistrationPeriodRequest;
use App\Http\Requests\UploadDokumenRequest;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Registration;
use App\Models\RegistrationPeriod;
use Carbon\Carbon;
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

    public function daftar(StoreDaftarRequest $request)
    {
        if (! $request->user()->can('daftar_siswa')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }
        $data = $request->validated();
        $registrationPeriod = RegistrationPeriod::where('is_open', true)->first();
        $data['registration_period_id'] = $registrationPeriod->id;
        $data['registration_number'] = $this->generateRegistrationNumber($data['jenjang']);
        //dd($data);
        $student = $request->user()->student;
        $existingRegistration = Registration::where('student_id', $student->id)->first();

        if ($existingRegistration) {
            return response()->json([
                'message' => 'Siswa telah terdaftar di sekolah tersebut.',
            ], 400);
        }
        $student->registration()->create($data);
        $documentTypes = DocumentType::all();
        foreach ($documentTypes as $documentType) {
            $student->registration->documents()->create([
                'document_type_id' => $documentType->id,
                'status' => 'belum upload',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $student->registration,
        ]);
    }

    public function uploadDokumen(UploadDokumenRequest $request, Registration $registration)
    {
        if (! $request->user()->can('upload_document_siswa')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }
        if ($registration->student_id !== $request->user()->student->id) {
            return response()->json([
                'message' => 'Anda mengaupload ke pendaftaran yang bukan milik anda.',
            ], 403);
        }
        $data = $request->validated();
        $document = $request->file('document');
        $documentType = str_replace(['/', '\\'], '_', Str::snake(DocumentType::find($data['document_type_id'])->label));
        $extension = $request->file('document')->getClientOriginalExtension();
        $filename = "{$documentType}.{$extension}";

        $path = $document->storeAs('uploads/registration/dokumen/'.$registration->id, $filename, 'public');
        $data['path'] = $path;
        $registration->documents()->create($data);

        return response()->json([
            'success' => true,
            'url' => asset(Storage::url($path)),
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
        if ($request->hasFile('document')) {
            $oldPath = $document->path;
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            // Store the new document
            $document_file = $request->file('document');
            $label = $document->documentType->label;
            $documentType = str_replace(['/', '\\'], '_', Str::snake($label));
            $extension = $document_file->getClientOriginalExtension();
            $filename = "{$documentType}.{$extension}";
            $registration = $document->registration;

            $path = $document_file->storeAs('uploads/registration/dokumen/'.$registration->id.'/', $filename, 'public');
            $data['path'] = $path;
            $document->update(['path' => $path]);

            return response()->json([
                'success' => true,
                'message' => 'Document updated successfully.',
                'document' => $document,
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

    public function cekPendaftaran()
    {
        $registration = Registration::where('student_id', auth()->user()->student->id)->first();

        return response()->json([
            'registration' => $registration->load('school', 'documents'),
        ]);
    }

    public function dokumen()
    {
        /* if(! auth()->user()->can('upload_document_siswa')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        } */

        $registration = Registration::where('student_id', auth()->user()->student->id)->first();
        $documents = $registration->documents;
        $documents->load('documentType');

        return response()->json(
            $documents);
    }
}
