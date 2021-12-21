<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Order;
use App\Repositories\Activities;
use App\Role;
use Exception;
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
    public function update(Request $request, Order $invoice)
    {
        $request->user()->authorizeRoles(['Administrador']);
        request()->validate([
            'dispatched' => $request->dispatched ? 'date' : '',
            'price' => $request->price ? 'numeric' : '',
            'sale_price' => $request->sale_price ? 'numeric' : '',
            'bol_load' => $request->bol_load ? 'numeric' : '',
            'bol_load2' => $request->bol_load2 ? 'numeric' : '',
            'dispatched_liters' => $request->dispatched_liters ? 'numeric' : '',
            'root_liters' => $request->root_liters ? 'numeric' : '',
            'name_freight' => $request->name_freight ? 'min:3' : '',
            'CFDI' => $request->CFDI ? 'string' : '',
            'file_pdf' => $request->file('file_pdf') ? 'required|file|mimes:pdf' : '',
            'file_xml' => $request->file('file_xml') ? 'required|file|mimes:xml' : '',
            'CFDI2' => $request->CFDI2 ? 'string' : '',
            'file_pdf2' => $request->file('file_pdf2') ? 'required|file|mimes:pdf' : '',
            'file_xml2' => $request->file('file_xml2') ? 'required|file|mimes:xml' : '',
        ]);
        $activity = new Activities();
        if ($request->file("file_pdf"))
            $activity->saveFile($request, $invoice, 'pdf');
        if ($request->file("file_pdf2"))
            $activity->saveFile($request, $invoice, 'pdf2');
        if ($request->file("file_xml")) {
            // leyendo archivo xml y actualizando total y folio UUID
            $activity->saveFile($request, $invoice, 'xml');
            $xml = $activity->xmlTotalFolioUUID($request->file('file_xml'));
            if (!$xml) return redirect()->back()->withStatus('El archivo xml no pudo ser leído');
            $invoice->update(['invoice' => $xml['total'], 'invoicefolio' => $xml['folio']]);
        }
        if ($request->file("file_xml2")) {
            // leyendo archivo xml y actualizando total y folio UUID
            $activity->saveFile($request, $invoice, 'xml2');
            $xml = $activity->xmlTotalFolioUUID($request->file('file_xml2'));
            if (!$xml) return redirect()->back()->withStatus('El archivo xml no pudo ser leído');
            $invoice->update(['invoice2' => $xml['total'], 'invoicefolio2' => $xml['folio']]);
        }
        $request->merge(['total' => $request->price * $invoice->liters]);
        $invoice->update($request->only([
            'dispatched', 'dispatched_liters', 'root_liters', 'bol_load', 'bol_load2', 'name_freight',
            'CFDI', 'CFDI2', 'sale_price', 'price', 'total'
        ]));
        return redirect()->back()->withStatus('Datos de facturación actualizados correctamente');
    }
    // Actualización de facturación Valero - Guerrera
    public function updateinvoice(Request $request, Order $invoice)
    {
        $request->user()->authorizeRoles(['Administrador']);
        request()->validate([
            'invoicecfdi' => 'required|string|min:3',
            'invoicecfdi' => $request->invoicecfdi2 ? 'string|min:3' : '',
            'file_invoicepdf' => $request->file_invoicepdf ? 'file|mimes:pdf' : '',
            'file_invoicexml' => $request->file_invoicexml ? 'file|mimes:xml' : '',
            'file_invoicepdf2' => $request->file_invoicepdf2 ? 'file|mimes:pdf' : '',
            'file_invoicexml2' => $request->file_invoicexml2 ? 'file|mimes:xml' : ''
        ]);
        $activity = new Activities();
        if ($request->file("file_invoicepdf")) $activity->saveFile($request, $invoice, 'invoicepdf');
        if ($request->file("file_invoicepdf2")) $activity->saveFile($request, $invoice, 'invoicepdf2');
        if ($request->file("file_invoicexml")) {
            $activity->saveFile($request, $invoice, 'invoicexml');
            $xml = $activity->xmlTotalFolioUUID($request->file('file_invoicexml'));
            if (!$xml) return redirect()->back()->withStatus('El archivo xml no pudo ser leído');
            $invoice->update(['invoicepayment' => $xml['total'], 'paymentfolio' => $xml['folio']]);
        }
        if ($request->file("file_invoicexml2")) {
            $activity->saveFile($request, $invoice, 'invoicexml2');
            $xml = $activity->xmlTotalFolioUUID($request->file('file_invoicexml2'));
            if (!$xml) return redirect()->back()->withStatus('El archivo xml no pudo ser leído');
            $invoice->update(['invoicepayment2' => $xml['total'], 'paymentfolio2' => $xml['folio']]);
        }
        $invoice->update($request->only(['invoicecfdi', 'invoicecfdi2']));
        return redirect()->back()->withStatus('Datos de facturación Valero - Guerrera actualizados correctamente');
    }
    // descarga de archivo pdf o xml
    public function download(Request $request, Order $order, $file, $type)
    {
        $request->user()->authorizeRoles(['Administrador', 'Cliente']);
        try {
            return Response::download(public_path() . $order->$file, "Factura {$order->company->name}.$type");
        } catch (Exception $e) {
            return redirect()->back()->withStatus('El archivo que intenta descargar no ha sido guardado')->withColor('danger');
        }
    }
    // Actualizacion de transportista
    public function shipper(Request $request, Order $invoice)
    {
        $request->user()->authorizeRoles(['Administrador']);
        request()->validate([
            'file_shipperpdf' => $request->file_shipperpdf ? 'file|mimes:pdf' : '',
            'file_shipperxml' => $request->file_shipperxml ? 'file|mimes:xml' : '',
            'invoice_shipper' => $request->invoice_shipper ? 'numeric' : '',
        ]);
        $activity = new Activities();
        if ($request->file_shipperpdf)
            $activity->saveFile($request, $invoice, 'shipperpdf');
        if ($request->file('file_shipperxml')) {
            $activity->saveFile($request, $invoice, 'shipperxml');
            $xml = $activity->xmlTotalFolioUUID($request->file('file_shipperxml'));
            if ($xml) {
                $invoice->update([
                    'shipper' => $xml['shipper'], 'shipperfolio' => $xml['folio'],
                    'invoice_shipper' => $request->invoice_shipper ?? $xml['total'],
                ]);
            } else {
                return redirect()->back()->withStatus('El archivo xml no pudo ser leído');
            }
        } else {
            $invoice->update($request->only(['invoice_shipper']));
        }
        $invoice->update($request->only(['number_shipper']));
        return redirect()->back()->withStatus('Datos de factura transporte actualizados correctamente');
    }
    // Actualizar notas de credito
    public function credit(Request $request, Order $invoice)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $activity = new Activities();
        if ($request->file("file_creditpdf")) {
            request()->validate(['file_creditpdf' => 'required|file|mimes:pdf']);
            $activity->saveFile($request, $invoice, 'creditpdf');
        }
        if ($request->file("file_creditxml")) {
            request()->validate(['file_creditxml' => 'required|file|mimes:xml']);
            $activity->saveFile($request, $invoice, 'creditxml');
            $xml = $activity->xmlTotalFolioUUID($request->file('file_creditxml'));
            if (!$xml) return redirect()->back()->withStatus('El archivo xml no pudo ser leído');
            $invoice->update(['credit' => $xml['folio'], 'amount' => $xml['total']]);
        }
        return redirect()->back()->withStatus('Nota de crédito actualizada correctamente');
    }
}
