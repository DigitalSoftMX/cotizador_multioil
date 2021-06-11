<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['company_id', 'terminal_id', 'liters_r', 'liters_p', 'liters_d', 'total_r', 'total_p', 'total_d', 'total', 'date', 'freight', 'secure', 'status_id'];
    // Relacion con las empresas
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    // Rela con las terminales
    public function terminal()
    {
        return $this->belongsTo(Terminal::class);
    }
}
