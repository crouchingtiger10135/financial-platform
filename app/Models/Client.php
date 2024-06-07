<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function hasUploadedDocument()
    {
        return $this->documents()->exists();
    }

    public function isIdentityVerified()
    {
        return $this->identity_verification_status;
    }
}
