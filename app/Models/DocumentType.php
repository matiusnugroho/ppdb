<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'label',
    ];

    public $incrementing = false;

    /**
     * Get the documents associated with the document type.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
