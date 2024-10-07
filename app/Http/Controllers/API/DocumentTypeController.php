<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;

class DocumentTypeController extends Controller
{
    public function index()
    {
        return DocumentType::get(['label', 'id']);
    }
}
