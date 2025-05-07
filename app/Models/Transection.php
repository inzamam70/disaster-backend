<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transection extends Model
{
    use HasFactory;
    protected $fillable = [
        'aid_id',
        'amount',
        'payment_method'
    ];

    public function aid()
    {
        return $this->belongsTo(Aid::class);
    }
}
