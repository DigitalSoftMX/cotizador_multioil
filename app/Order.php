<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'company_id', 'terminal_id', 'freight', 'name_freight', 'secure',
        'price', 'sale_price', 'liters', 'product', 'total', 'date', 'dispatched',
        'dispatched_liters', 'root_liters', 'invoice', 'invoicefolio', 'CFDI', 'pdf', 'xml',
        'invoice2', 'invoicefolio2', 'CFDI2', 'pdf2', 'xml2',
        'status_id', 'commission', 'user_id', 'commission_two', 'middleman_id',
        'reason', 'invoicepayment', 'paymentfolio', 'invoicecfdi', 'invoicepdf', 'invoicexml',
        'invoicepayment2', 'paymentfolio2', 'invoicecfdi2', 'invoicepdf2', 'invoicexml2',
        'shipper', 'number_shipper', 'invoice_shipper', 'shipperpdf', 'shipperxml',
        'shipperfolio', 'bol_load', 'bol_load2', 'credit', 'amount', 'creditpdf', 'creditxml',
        'type', 'created_at'
    ];
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
