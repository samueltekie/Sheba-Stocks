<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'movement_type',
        'quantity',
        'description',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
