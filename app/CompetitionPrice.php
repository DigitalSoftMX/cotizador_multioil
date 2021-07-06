<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionPrice extends Model
{
    protected $table = 'prices';
    protected $fillable = ['company_id', 'terminal_id', 'regular', 'premium', 'diesel', 'regular_sf', 'premium_sf', 'diesel_sf', 'created_at', 'updated_at'];
    // Relacion con la terminal
    public function terminal()
    {
        return $this->belongsTo(Terminal::class);
    }
    // Relacion con la empresa
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
