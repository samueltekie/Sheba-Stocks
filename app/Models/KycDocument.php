<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KycDocument extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'document_type', 'document_path', 'verified'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}