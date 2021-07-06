<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Order $order)
    {
        $request->user()->authorizeRoles(['Administrador']);
        if ($request->payment_guerrera == null && $request->payment_g_valero == null && $request->payment_freight == null)
            return redirect()->back()->withStatus('Debe ingresar al menos un tipo de pago')->withColor('danger');
        Payment::create($request->merge(['order_id' => $order->id])->all());
        return redirect()->back()->withStatus('Pago registrado correctamente');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order, Payment $payment)
    {
        $request->user()->authorizeRoles(['Administrador']);
        if ($request->payment_guerrera == null && $request->payment_g_valero == null && $request->payment_freight == null)
            return redirect()->back()->withStatus('Debe ingresar al menos un tipo de pago')->withColor('danger');
        $payment->update($request->except('order_id'));
        return redirect()->back()->withStatus('Pago actualizado correctamente');
    }
}
