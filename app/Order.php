<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['company_id', 'terminal_id', 'freight', 'name_freight', 'secure', 'price', 'sale_price', 'liters', 'product', 'total', 'date', 'dispatched', 'dispatched_liters', 'root_liters', 'invoice', 'CFDI', 'pdf', 'xml', 'status_id', 'commission', 'user_id', 'commission_two', 'middleman_id', 'reason', 'invoicepayment', 'invoicecfdi', 'invoicepdf', 'invoicexml'];
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
    // Relacion con los pagos
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
