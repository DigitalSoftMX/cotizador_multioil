<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Http\Controllers\Controller;
use App\Order;
use App\Repositories\Activities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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
        request()->validate(['created_at' => 'required|date_format:Y-m-d']);
        if (!$request->payment_guerrera && !$request->payment_g_valero && !$request->payment_freight)
            return redirect()->back()->withStatus('Debe ingresar al menos un tipo de pago')->withColor('danger');
        $payment = Payment::create($request->merge(['order_id' => $order->id])->all());
        $savingFile = new Activities();
        $savingFile->saveOrUpdatePayments($request, $payment);
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
        request()->validate(['created_at' => 'required|date_format:Y-m-d']);
        if (!$request->payment_guerrera && !$request->payment_g_valero && !$request->payment_freight)
            return redirect()->back()->withStatus('Debe ingresar al menos un tipo de pago')->withColor('danger');
        $savingFile = new Activities();
        $payment->update($request->except('order_id'));
        $savingFile->saveOrUpdatePayments($request, $payment);
        return redirect()->back()->withStatus('Pago actualizado correctamente');
    }
    // Descarga de archivos "factura" de los pagos de cada pedido
    public function downloadVoucher(Request $request, Payment $payment, $file)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $extention = explode('.', $payment->vouchervalero);
        switch ($file) {
            case 'guerrera':
                $extention = explode('.', $payment->voucherguerrera);
                return Response::download(public_path() . $payment->voucherguerrera, "Factura {$payment->order->name} Guerrera.{$extention[1]}");
            case 'valero':
                $extention = explode('.', $payment->vouchervalero);
                return Response::download(public_path() . $payment->vouchervalero, "Factura {$payment->order->name} Guerrera-Valero.{$extention[1]}");
            case 'fletera':
                $extention = explode('.', $payment->voucherfreight);
                return Response::download(public_path() . $payment->voucherfreight, "Factura {$payment->order->name} Fletera.{$extention[1]}");
            default:
                return redirect()->back()->withStatus('archivo no encontrado')->withColor('danger');
        }
    }
}
