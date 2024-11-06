<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentTypeRequest;
use App\Models\DocumentType;

class DocumentTypeController extends Controller
{
    public function index()
    {
        return DocumentType::get(['label', 'id']);
    }

    public function store(DocumentTypeRequest $request)
    {
        $data = $request->validated();
        $documentType = DocumentType::create($data);

        return response()->json([
            'success' => true,
            'data' => $documentType,
        ]);
    }

    public function update(DocumentTypeRequest $request, DocumentType $documentType)
    {
        $data = $request->validated();
        $documentType->update($data);

        return response()->json([
            'success' => true,
            'data' => $documentType,
        ]);
    }

    public function destroy(DocumentType $documentType)
    {
        $documentType->delete();

        return response()->json([
            'success' => true,
            'data' => $documentType,
        ]);
    }
}
