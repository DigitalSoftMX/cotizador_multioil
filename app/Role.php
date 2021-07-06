<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = ['id'];
    // Relacion con los usuarios
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    // relación con los menús
    public function menus()
    {
        return $this->belongsToMany('App\Menu');
    }
}
