<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'url',
        'position'


    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'nav_item_role', 'nav_id', 'active_role_id');
    }
}
