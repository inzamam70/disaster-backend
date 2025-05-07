<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'title',
        'content',
        'image',
        'user_id',
        'affectedtype_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function affectedType()
    {
        return $this->belongsTo(AffectedType::class, 'affectedtype_id');
    }
}
