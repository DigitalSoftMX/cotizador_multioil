<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id', 'payment_guerrera', 'voucherguerrera', 'payment_g_valero',
        'vouchervalero', 'payment_freight', 'voucherfreight', 'created_at'
    ];
    // Relacion con los pedidos
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
