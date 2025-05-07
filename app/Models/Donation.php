<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'amount','transection_id', 'payment_method'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function fund()
    {
        return $this->hasOne(Fund::class);
    }
}
