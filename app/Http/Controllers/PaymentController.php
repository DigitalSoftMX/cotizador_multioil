<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Http\Controllers\Controller;
use App\Order;
use App\Repositories\Activities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

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
        if ($request->payment_guerrera)
            request()->validate(['file_voucherguerrera' => 'required|file']);
        if ($request->payment_g_valero)
            request()->validate(['file_vouchervalero' => 'required|file']);
        if ($request->payment_freight)
            request()->validate(['file_voucherfreight' => 'required|file']);
        $savingFile = new Activities();
        $payment = Payment::create($request->merge(['order_id' => $order->id])->all());
        if ($request->payment_guerrera)
            $savingFile->saveFile($request, $payment, 'voucherguerrera', 'payments');
        if ($request->payment_g_valero)
            $savingFile->saveFile($request, $payment, 'vouchervalero', 'payments');
        if ($request->payment_freight)
            $savingFile->saveFile($request, $payment, 'voucherfreight', 'payments');
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
        if ($request->payment_guerrera and $payment->voucherguerrera == null)
            request()->validate(['file_voucherguerrera' => 'required|file']);
        if ($request->payment_g_valero and $payment->vouchervalero == null)
            request()->validate(['file_vouchervalero' => 'required|file']);
        if ($request->payment_freight and $payment->voucherfreight == null)
            request()->validate(['file_voucherfreight' => 'required|file']);
        $savingFile = new Activities();
        $payment->update($request->except('order_id'));
        if ($request->payment_guerrera)
            $savingFile->saveFile($request, $payment, 'voucherguerrera', 'payments');
        if ($request->payment_g_valero)
            $savingFile->saveFile($request, $payment, 'vouchervalero', 'payments');
        if ($request->payment_freight)
            $savingFile->saveFile($request, $payment, 'voucherfreight', 'payments');
        if (!$request->payment_guerrera) {
            if (File::exists(public_path() . $payment->voucherguerrera))
                File::delete(public_path() . $payment->voucherguerrera);
            $payment->update(['voucherguerrera' => null]);
        }
        if (!$request->payment_g_valero) {
            if (File::exists(public_path() . $payment->vouchervalero))
                File::delete(public_path() . $payment->vouchervalero);
            $payment->update(['vouchervalero' => null]);
        }
        if (!$request->payment_freight) {
            if (File::exists(public_path() . $payment->voucherfreight))
                File::delete(public_path() . $payment->voucherfreight);
            $payment->update(['voucherfreight' => null]);
        }
        return redirect()->back()->withStatus('Pago actualizado correctamente');
    }
    // Descarga de archivos "factura" de los pagos de cada pedido
    public function downloadVoucher(Request $request, Payment $payment, $file)
    {
        $request->user()->authorizeRoles(['Administrador']);
        switch ($file) {
            case 'guerrera':
                $extention = explode('.', $payment->voucherguerrera);
                return Response::download(public_path() . $payment->voucherguerrera, "Factura {$payment->order->name} Guerrera.{$extention[1]}");
            case 'valero':
                $extention = explode('.', $payment->voucherguerrera);
                return Response::download(public_path() . $payment->vouchervalero, "Factura {$payment->order->name} Guerrera-Valero.{$extention[1]}");
            case 'fletera':
                $extention = explode('.', $payment->voucherguerrera);
                return Response::download(public_path() . $payment->voucherfreight, "Factura {$payment->order->name} Fletera.{$extention[1]}");
            default:
                return redirect()->back()->withStatus('archivo no encontrado')->withColor('danger');
        }
    }
}
