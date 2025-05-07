<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCenter extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'location',
        'description',
        'opening_hours',
        'closing_hours',
        'center_type',
        'image'
    ];
}
