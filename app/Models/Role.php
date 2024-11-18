<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function roleNavItems()
    {
        return $this->hasMany(RoleNavItem::class, 'nav_item_role');	
    }

    public function navItems()
    {
        return $this->belongsToMany(Nav::class, 'nav_item_role', 'role_id', 'nav_id');
    }
}
