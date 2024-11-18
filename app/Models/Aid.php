<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aid extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'name',
        'phone',
        'email',
        'aid',
        'qty',
        'landingcard_id',
        'user_id',
        'status',
    ];

    

    public function landingcard()
{
    return $this->belongsTo(Landingcard::class, 'landingcard_id');
}


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
