<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'type', 'reference_id', 'amount', 'currency', 'data', 'status'
    ];

    protected $casts = [
        'data' => 'json',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
