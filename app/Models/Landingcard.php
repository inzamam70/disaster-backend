<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Landingcard extends Model
{
    use HasFactory;
    protected $with = array('affectedType');
    protected  $fillable = [
        'title',
        'description',
        'image',
        'affectedtype_id',
        'latitude',
        'longitude'
    ];

    public function affectedType()
    {
        return $this->belongsTo(AffectedType::class, 'affectedtype_id');
    }

}
