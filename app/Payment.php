<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['order_id', 'payment_guerrera', 'payment_g_valero', 'payment_freight'];
}
