@extends('layouts.app', ['activePage' => 'Validación de pedidos', 'titlePage' => __('Facturación y pagos')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">
                                <a href="{{ route('validations.index') }}" title="Volver a la lista de pedidos">
                                    <span class="material-icons">arrow_back_ios</span>
                                </a>
                                {{ __('Facturación y pagos del pedido') }}
                            </h4>
                        </div>
                        <div class="card-body">
                            @include('partials._notification')
                            <div class="row">
                                <label class="col-12">
                                    <h5>{{ __('Datos del pedido:') }}</h5>
                                </label>
                                <label class="col-md-4 col-sm-12">
                                    <h6>{{ 'Empresa: ' . $invoice->company->name }}</h6>
                                    <h6>{{ 'Terminal: ' . $invoice->terminal->name }}</h6>
                                    <h6>{{ 'Producto: ' }} {{ $invoice->product }}
                                        {{ 'litros: ' }}
                                        {{ number_format($invoice->liters, 0) . ' lts' }} <br>
                                        {{ 'importe: ' }}
                                        {{ '$ ' . number_format($invoice->total, 2) }}
                                    </h6>
                                </label>
                                <div class="col-md-4 col-sm-12">
                                    <label>
                                        <h6>Cantidad a pagar:</h6>
                                    </label>
                                    <strong>
                                        {{ '$ ' . number_format($invoice->invoice != null && $invoice->invoice > 0 ? $invoice->invoice : $invoice->total, 2) }}
                                    </strong><br>
                                    <label>
                                        <h6>Cantidad pagada:</h6>
                                    </label>
                                    <strong>{{ '$ ' . number_format($invoice->payments->sum('payment_guerrera'), 2) }}</strong>
                                    <br>
                                    <label>
                                        <h6>Cantidad restante:</h6>
                                    </label>
                                    <strong
                                        style="{{ ($invoice->invoice != null && $invoice->invoice > 0 ? $invoice->invoice : $invoice->total) - $invoice->payments->sum('payment_guerrera') > 0 ? 'color:red;' : 'color:blue;' }}">
                                        {{ '$ ' . number_format(($invoice->invoice != null && $invoice->invoice > 0 ? $invoice->invoice : $invoice->total) - $invoice->payments->sum('payment_guerrera'), 2) }}
                                    </strong>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label>
                                        <h6>Cliente La Guerrera:</h6>
                                    </label>
                                    <strong>{{ '$ ' . number_format($invoice->payments->sum('payment_guerrera'), 2) }}</strong><br>
                                    <label>
                                        <h6>Cliente La Guerrera Valero:</h6>
                                    </label>
                                    <strong>{{ '$ ' . number_format($invoice->payments->sum('payment_g_valero'), 2) }}</strong><br>
                                    <label>
                                        <h6>Fletera:</h6>
                                    </label>
                                    <strong>{{ '$ ' . number_format($invoice->payments->sum('payment_freight'), 2) }}</strong><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-right">
                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                        data-target=".bd-example-modal-lg-commission">{{ ($invoice->commission != null ? 'Actualizar' : 'Agregar') . __(' comisión') }}</button>
                                    <div class="modal fade bd-example-modal-lg-commission" tabindex="-1" role="dialog"
                                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form method="post" action="{{ route('orders.update', $invoice) }}"
                                                    autocomplete="off" class="form-horizontal">
                                                    @method('put')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">
                                                            <strong>{{ ($invoice->commission != null ? 'Actualización' : 'Registro') . __(' de comisión') }}</strong>
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row justify-content-center">
                                                            <div
                                                                class="form-group{{ $errors->has('commission') ? ' has-danger' : '' }} col-lg-4 col-sm-12">
                                                                <label
                                                                    for="commission">{{ __('Comisión del cliente') }}</label>
                                                                <input type="number"
                                                                    class="form-control{{ $errors->has('commission') ? ' is-invalid' : '' }}"
                                                                    id="input-commission" aria-describedby="commissionHelp"
                                                                    placeholder="Escribe la cantidad del pago"
                                                                    value="{{ old('commission', $invoice->commission) }}"
                                                                    aria-required="true" name="commission" step="any">
                                                                @if ($errors->has('commission'))
                                                                    <span id="commission-error" class="error text-danger"
                                                                        for="input-commission">
                                                                        {{ $errors->first('commission') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div
                                                                class="form-group{{ $errors->has('user_id') ? ' has-danger' : '' }} col-lg-4 col-sm-12">
                                                                <select id="input-user_id" name="user_id"
                                                                    class="selectpicker show-menu-arrow {{ $errors->has('user_id') ? ' has-danger' : '' }}"
                                                                    data-style="btn-primary" data-width="100%"
                                                                    data-live-search="true">
                                                                    <option value="">Elija un vendedor</option>
                                                                    @foreach ($sales as $sale)
                                                                        <option value="{{ $sale->id }}" @if ($invoice->user_id == $sale->id) selected @endif>
                                                                            {{ $sale->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('user_id'))
                                                                    <span id="name-user_id" class="error text-danger"
                                                                        for="input-user_id">{{ $errors->first('user_id') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit"
                                                            class="btn btn-primary">{{ 'Actualizar' }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-ms-12">
                                    <form method="post" action="{{ route('invoices.update', $invoice) }}"
                                        autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                                        @method('put')
                                        @csrf
                                        <div class="card ">
                                            <div class="card-header">
                                                <h4 class="card-title">{{ __('Datos de facturación') }}</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 text-right">
                                                        @if ($invoice->xml != null)
                                                            <a href="{{ route('download', [$invoice, 'pdf']) }}"
                                                                class="btn btn-sm btn-success">{{ __('Descargar pdf') }}</a>
                                                        @endif
                                                        @if ($invoice->pdf != null)
                                                            <a href="{{ route('download', [$invoice, 'xml']) }}"
                                                                class="btn btn-sm btn-success">{{ __('Descargar xml') }}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center mt-3">
                                                    <div
                                                        class="form-group{{ $errors->has('dispatched') ? ' has-danger' : '' }} col-12">
                                                        <label
                                                            class="label-control">{{ __('Fecha de despacho') }}</label>
                                                        <input class="form-control datetimepicker" id="calendar_first"
                                                            name="dispatched" type="text"
                                                            value="{{ old('dispatched', $invoice->dispatched) }}" />
                                                        @if ($errors->has('dispatched'))
                                                            <span id="dispatched-error" class="error text-danger"
                                                                for="input-dispatched">
                                                                {{ $errors->first('dispatched') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div
                                                        class="form-group{{ $errors->has('price') ? ' has-danger' : '' }} col-12">
                                                        <label for="price">{{ __('Precio de compra') }}</label>
                                                        <input type="number"
                                                            class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}"
                                                            id="input-price" aria-describedby="priceHelp"
                                                            placeholder="Escribe el precio de compra por litro"
                                                            value="{{ old('price', $invoice->price) }}"
                                                            aria-required="true" name="price" step="any">
                                                        @if ($errors->has('price'))
                                                            <span id="price-error" class="error text-danger"
                                                                for="input-price">
                                                                {{ $errors->first('price') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div
                                                        class="form-group{{ $errors->has('sale_price') ? ' has-danger' : '' }} col-12">
                                                        <label for="sale_price">{{ __('Precio de venta') }}</label>
                                                        <input type="number"
                                                            class="form-control{{ $errors->has('sale_price') ? ' is-invalid' : '' }}"
                                                            id="input-sale_price" aria-describedby="sale_priceHelp"
                                                            placeholder="Escribe el precio de venta por litro"
                                                            value="{{ old('sale_price', $invoice->sale_price) }}"
                                                            aria-required="true" name="sale_price" step="any">
                                                        @if ($errors->has('sale_price'))
                                                            <span id="sale_price-error" class="error text-danger"
                                                                for="input-sale_price">
                                                                {{ $errors->first('sale_price') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div
                                                        class="form-group{{ $errors->has('dispatched_liters') ? ' has-danger' : '' }} col-12">
                                                        <label
                                                            for="dispatched_liters">{{ __('Litros despachados') }}</label>
                                                        <input type="number"
                                                            class="form-control{{ $errors->has('dispatched_liters') ? ' is-invalid' : '' }}"
                                                            id="input-dispatched_liters"
                                                            aria-describedby="dispatched_litersHelp"
                                                            placeholder="Escribe la cantidad de litros despachados"
                                                            value="{{ old('dispatched_liters', $invoice->dispatched_liters) }}"
                                                            aria-required="true" name="dispatched_liters" step="any">
                                                        @if ($errors->has('dispatched_liters'))
                                                            <span id="dispatched_liters-error" class="error text-danger"
                                                                for="input-dispatched_liters">
                                                                {{ $errors->first('dispatched_liters') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div
                                                        class="form-group{{ $errors->has('invoice') ? ' has-danger' : '' }} col-12">
                                                        <label for="invoice">{{ __('Cantidad facturada') }}</label>
                                                        <input type="number"
                                                            class="form-control{{ $errors->has('invoice') ? ' is-invalid' : '' }}"
                                                            id="input-invoice" aria-describedby="invoiceHelp"
                                                            placeholder="Escribe la cantidad facturada"
                                                            value="{{ old('invoice', $invoice->invoice) }}"
                                                            aria-required="true" name="invoice" step="any">
                                                        @if ($errors->has('invoice'))
                                                            <span id="invoice-error" class="error text-danger"
                                                                for="input-invoice">
                                                                {{ $errors->first('invoice') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div
                                                        class="form-group{{ $errors->has('CFDI') ? ' has-danger' : '' }} col-12">
                                                        <label for="CFDI">{{ __('Factura') }}</label>
                                                        <input type="text"
                                                            class="form-control{{ $errors->has('CFDI') ? ' is-invalid' : '' }}"
                                                            id="input-CFDI" aria-describedby="CFDIHelp"
                                                            placeholder="Escribe la factura"
                                                            value="{{ old('CFDI', $invoice->CFDI) }}"
                                                            aria-required="true" name="CFDI" step="any">
                                                        @if ($errors->has('CFDI'))
                                                            <span id="CFDI-error" class="error text-danger"
                                                                for="input-CFDI">
                                                                {{ $errors->first('CFDI') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div
                                                        class="form-group{{ $errors->has('name_freight') ? ' has-danger' : '' }} col-12">
                                                        <label
                                                            for="name_freight">{{ __('Nombre de la fletera') }}</label>
                                                        <input type="text"
                                                            class="form-control{{ $errors->has('name_freight') ? ' is-invalid' : '' }}"
                                                            id="input-name_freight" aria-describedby="name_freightHelp"
                                                            placeholder="Escribe el nombre de la fletera"
                                                            value="{{ old('name_freight', $invoice->name_freight) }}"
                                                            aria-required="true" name="name_freight" step="any">
                                                        @if ($errors->has('name_freight'))
                                                            <span id="name_freight-error" class="error text-danger"
                                                                for="input-name_freight">
                                                                {{ $errors->first('name_freight') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div class="col-sm-12">
                                                        <label>{{ __('Factura PDF') }}</label>
                                                        <input type="file" name="file_pdf" id="" accept=".pdf">
                                                        @if ($errors->has('file_pdf'))
                                                            <span id="text-file_pdf" class="error text-danger"
                                                                for="input-file_pdf">
                                                                <br> {{ $errors->first('file_pdf') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div class="col-sm-12">
                                                        <label>{{ __('Factura XML') }}</label>
                                                        <input type="file" name="file_xml" id="" accept=".xml">
                                                        @if ($errors->has('file_xml'))
                                                            <span id="text-file_xml" class="error text-danger"
                                                                for="input-file_xml">
                                                                <br> {{ $errors->first('file_xml') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="card-footer justify-content-center">
                                                    <button type="submit"
                                                        class="btn btn-primary">{{ __('Actualizar datos del pedido') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-8 col-ms-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ __('Pagos del pedido') }}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 text-right">
                                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                        data-target=".bd-example-modal-lg-payment">{{ __('Agregar pago') }}</button>
                                                    @include('partials._paymentmodal',[$type='payment'])
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table id="datatables" class="table">
                                                    <thead class=" text-primary">
                                                        <th>{{ __('Cliente La Guerrera') }}</th>
                                                        <th>{{ __('La Guerrera Valero') }}</th>
                                                        <th>{{ __('Fletera') }}</th>
                                                        <th>{{ __('Fecha') }}</th>
                                                        <th class="text-right">{{ __('Acciones') }}</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($payments as $payment)
                                                            <tr>
                                                                <td>{{ '$ ' . number_format($payment->payment_guerrera, 2) }}
                                                                </td>
                                                                <td>{{ '$ ' . number_format($payment->payment_g_valero, 2) }}
                                                                </td>
                                                                <td>{{ '$ ' . number_format($payment->payment_freight, 2) }}
                                                                </td>
                                                                <td>{{ $payment->created_at->format('Y/m/d') }}</td>
                                                                <td class="td-actions text-right">
                                                                    <button type="button" class="btn btn-success btn-link"
                                                                        data-toggle="modal"
                                                                        data-target=".bd-example-modal-lg-payment{{ $payment->id }}">
                                                                        <i class="material-icons">edit</i>
                                                                        <div class="ripple-container"></div>
                                                                    </button>
                                                                    @include('partials._paymentmodal',[$type='payment'.$payment->id])
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/ventas.js') }}"></script>
    <script>
        let date = new Date();
        $(document).ready(function() {
            init_calendar('calendar_first', `01-01-${date.getFullYear()}`, `12-31-${date.getFullYear()}`);
            loadTable('datatables');
        });
    </script>
@endpush
