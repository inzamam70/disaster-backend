<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;

    protected $fillable = [
        'current_balance'
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}
