<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Order;
use App\Repositories\Activities;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class InvoiceController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Order $invoice)
    {
        $request->user()->authorizeRoles(['Administrador', 'Cliente']);
        return view(
            'invoices.edit',
            ['invoice' => $invoice, 'payments' => $invoice->payments, 'sales' => Role::find(3)->users]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceRequest $request, Order $invoice)
    {
        $request->user()->authorizeRoles(['Administrador']);
        if ($invoice->pdf == null)
            request()->validate(['file_pdf' => 'required|file|mimes:pdf']);
        if ($invoice->xml == null)
            request()->validate(['file_xml' => 'required|file|mimes:xml']);
        $savingFile = new Activities();
        $savingFile->saveFile($request, $invoice, 'pdf');
        $savingFile->saveFile($request, $invoice, 'xml');
        $request->merge(['total' => $request->price * $invoice->liters]);
        $invoice->update($request->only(['dispatched', 'dispatched_liters', 'invoice', 'CFDI', 'sale_price', 'name_freight', 'price', 'total']));
        return redirect()->back()->withStatus('Datos de facturación actualizados correctamente');
    }
    // Actualización de facturación Valero - Guerrera
    public function updateinvoice(Request $request, Order $invoice)
    {
        $request->user()->authorizeRoles(['Administrador']);
        request()->validate(['invoicepayment' => 'required|numeric', 'invoicecfdi' => 'required|string|min:3']);
        if ($invoice->invoicepdf == null)
            request()->validate(['file_invoicepdf' => 'required|file|mimes:pdf']);
        if ($invoice->invoicexml == null)
            request()->validate(['file_invoicexml' => 'required|file|mimes:xml']);
        $savingFile = new Activities();
        $savingFile->saveFile($request, $invoice, 'invoicepdf');
        $savingFile->saveFile($request, $invoice, 'invoicexml');
        return redirect()->back()->withStatus('Datos de facturación Valero - Guerrera actualizados correctamente');
    }
    // descarga de archivo pdf o xml
    public function download(Request $request, Order $order, $file, $type)
    {
        $request->user()->authorizeRoles(['Administrador', 'Cliente']);
        return Response::download(public_path() . $order->$file, "Factura {$order->company->name}.$type");
    }
}
