<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $fillable = ['terminal_id', 'company_id', 'nflete', 'nseguro', 'regularL', 'regularMa', 'regularMi', 'regularJ', 'regularV', 'regularS', 'premiumL', 'premiumMa', 'premiumMi', 'premiumJ', 'premiumV', 'premiumS', 'dieselL', 'dieselMa', 'dieselMi', 'dieselJ', 'dieselV', 'dieselS', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'totalR', 'totalP', 'totalD', 'grantotal', 'status_id'];
    // relacion con la empresa
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    // relacion con las terminals
    public function terminal()
    {
        $this->belongsTo(Terminal::class);
    }
}
