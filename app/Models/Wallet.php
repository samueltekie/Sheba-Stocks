<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model {
    protected $fillable = ['user_id', 'total_balance', 'available_balance', 'invested_amount', 'pending_funds'];

    public function user() {
        return $this->belongsTo(User::class);  // Relationship with User
    }
}
