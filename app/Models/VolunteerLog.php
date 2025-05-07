<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerLog extends Model
{
    use HasFactory;
    protected $casts = [
        'landingcard_ids' => 'string', // Store a single ID as string
    ];
    
    protected $fillable = [
        'user_id',
        'tcenter_id',
        'clock_in',
        'clock_out',
        'total_hours',
        'landingcard_ids', // ✅ Make sure this is correct
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainingCenter()
    {
        return $this->belongsTo(TrainingCenter::class, 'tcenter_id');
    }

    public function landingCard()
    {
        return $this->belongsTo(Landingcard::class, 'landingcard_ids');
    }


}


