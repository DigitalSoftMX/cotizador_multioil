<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LastLogin extends Model
{
    protected $fillable = ['user_id'];
    // Relacion con los usuarios
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
