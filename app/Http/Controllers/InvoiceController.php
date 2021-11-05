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
        request()->validate(['bol_load' => $request->bol_load ? 'numeric' : '']);
        $savingFile = new Activities();
        if ($request->file("file_pdf")) {
            request()->validate(['file_pdf' => 'required|file|mimes:pdf']);
            $savingFile->saveFile($request, $invoice, 'pdf');
        }
        if ($request->file("file_xml")) {
            request()->validate(['file_xml' => 'required|file|mimes:xml']);
            $savingFile->saveFile($request, $invoice, 'xml');
        }
        $request->merge(['total' => $request->price * $invoice->liters]);
        $invoice->update($request->only(['dispatched', 'dispatched_liters', 'root_liters', 'bol_load', 'invoice', 'CFDI', 'sale_price', 'name_freight', 'price', 'total']));
        return redirect()->back()->withStatus('Datos de facturación actualizados correctamente');
    }
    // Actualización de facturación Valero - Guerrera
    public function updateinvoice(Request $request, Order $invoice)
    {
        $request->user()->authorizeRoles(['Administrador']);
        request()->validate(['invoicepayment' => 'required|numeric', 'invoicecfdi' => 'required|string|min:3']);
        $savingFile = new Activities();
        if ($request->file("file_invoicepdf")) {
            request()->validate(['file_invoicepdf' => 'required|file|mimes:pdf']);
            $savingFile->saveFile($request, $invoice, 'invoicepdf');
        }
        if ($request->file("file_invoicexml")) {
            request()->validate(['file_invoicexml' => 'required|file|mimes:xml']);
            $savingFile->saveFile($request, $invoice, 'invoicexml');
        }
        $invoice->update($request->only(['invoicepayment', 'invoicecfdi']));
        return redirect()->back()->withStatus('Datos de facturación Valero - Guerrera actualizados correctamente');
    }
    // descarga de archivo pdf o xml
    public function download(Request $request, Order $order, $file, $type)
    {
        $request->user()->authorizeRoles(['Administrador', 'Cliente']);
        return Response::download(public_path() . $order->$file, "Factura {$order->company->name}.$type");
    }
    // Actualizacion de transportista
    public function shipper(Request $request, Order $invoice)
    {
        $request->user()->authorizeRoles(['Administrador']);
        request()->validate([
            'shipper' => 'required|string', 'number_shipper' => 'required|string',
            'invoice_shipper' => 'required|numeric'
        ]);
        $invoice->update($request->only(['shipper', 'number_shipper', 'invoice_shipper']));
        return redirect()->back()->withStatus('Datos de factura transporte actualizados correctamente');
    }
    // Actualizar notas de credito
    public function credit(Request $request, Order $invoice)
    {
        $request->user()->authorizeRoles(['Administrador']);
        request()->validate(['credit' => 'required|string|min:3', 'amount' => 'required|numeric']);
        $savingFile = new Activities();
        if ($request->file("file_creditpdf")) {
            request()->validate(['file_creditpdf' => 'required|file|mimes:pdf']);
            $savingFile->saveFile($request, $invoice, 'creditpdf');
        }
        if ($request->file("file_creditxml")) {
            request()->validate(['file_creditxml' => 'required|file|mimes:xml']);
            $savingFile->saveFile($request, $invoice, 'creditxml');
        }
        $invoice->update($request->only(['credit', 'amount']));
        return redirect()->back()->withStatus('Nota de crédito actualizada correctamente');
    }
}
