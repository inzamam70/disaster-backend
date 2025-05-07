<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleNavitem extends Model
{
    use HasFactory;
    protected $fillable = [
        'role_id',
        'nav_id'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function nav()
    {
        return $this->belongsTo(Nav::class, 'nav_id');
    }
}
