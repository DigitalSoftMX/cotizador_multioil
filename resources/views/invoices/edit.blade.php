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
                            @include('partials.notification')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">
                                                <strong>{{ __('Datos del pedido:') }}</strong>
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 col-md-4">
                                                    <h6>{{ 'Empresa: ' . $invoice->company->name }}</h6>
                                                    <h6>{{ 'Terminal: ' . $invoice->terminal->name }}</h6>
                                                    <h6>{{ 'Producto: ' }} {{ $invoice->product }}
                                                        {{ 'litros: ' }}
                                                        {{ number_format($invoice->liters, 0) . ' lts' }} <br>
                                                        {{ 'importe: ' }}
                                                        {{ '$ ' . number_format($invoice->total, 2) }}
                                                    </h6>
                                                </div>
                                                <div class="col-12 col-md-4">
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
                                                <div class="col-12 col-md-4">
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (auth()->user()->roles->first()->id == 1)
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
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row justify-content-center">
                                                                <div
                                                                    class="form-group{{ $errors->has('commission') ? ' has-danger' : '' }} col-lg-4 col-sm-12">
                                                                    <label
                                                                        for="commission">{{ __('Comisión del comisionista') }}</label>
                                                                    <input type="number"
                                                                        class="form-control{{ $errors->has('commission') ? ' is-invalid' : '' }}"
                                                                        id="input-commission"
                                                                        aria-describedby="commissionHelp"
                                                                        placeholder="Escribe la cantidad del pago"
                                                                        value="{{ old('commission', $invoice->commission) }}"
                                                                        aria-required="true" name="commission" step="any">
                                                                    @if ($errors->has('commission'))
                                                                        <span id="commission-error"
                                                                            class="error text-danger"
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
                                                                        <option value="">
                                                                            {{ __('Elija un comisionista') }}
                                                                        </option>
                                                                        @foreach ($sales as $sale)
                                                                            <option value="{{ $sale->id }}"
                                                                                @if ($invoice->user_id == $sale->id) selected @endif>
                                                                                {{ $sale->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if ($errors->has('user_id'))
                                                                        <span id="name-user_id" class="error text-danger"
                                                                            for="input-user_id">{{ $errors->first('user_id') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="row justify-content-center">
                                                                <div
                                                                    class="form-group{{ $errors->has('commission_two') ? ' has-danger' : '' }} col-lg-4 col-sm-12">
                                                                    <label
                                                                        for="commission_two">{{ __('Comisión del segundo comisionista') }}</label>
                                                                    <input type="number"
                                                                        class="form-control{{ $errors->has('commission_two') ? ' is-invalid' : '' }}"
                                                                        id="input-commission_two"
                                                                        aria-describedby="commission_twoHelp"
                                                                        placeholder="Escribe la cantidad del pago"
                                                                        value="{{ old('commission_two', $invoice->commission_two) }}"
                                                                        aria-required="true" name="commission_two"
                                                                        step="any">
                                                                    @if ($errors->has('commission_two'))
                                                                        <span id="commission_two-error"
                                                                            class="error text-danger"
                                                                            for="input-commission_two">
                                                                            {{ $errors->first('commission_two') }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div
                                                                    class="form-group{{ $errors->has('middleman_id') ? ' has-danger' : '' }} col-lg-4 col-sm-12">
                                                                    <select id="input-middleman_id" name="middleman_id"
                                                                        class="selectpicker show-menu-arrow {{ $errors->has('middleman_id') ? ' has-danger' : '' }}"
                                                                        data-style="btn-primary" data-width="100%"
                                                                        data-live-search="true">
                                                                        <option value="">
                                                                            {{ __('Elija un comisionista') }}
                                                                        </option>
                                                                        @foreach ($sales as $sale)
                                                                            <option value="{{ $sale->id }}"
                                                                                @if ($invoice->middleman_id == $sale->id) selected @endif>
                                                                                {{ $sale->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if ($errors->has('middleman_id'))
                                                                        <span id="name-middleman_id"
                                                                            class="error text-danger"
                                                                            for="input-middleman_id">{{ $errors->first('middleman_id') }}</span>
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
                            @endif
                            <div class="row">
                                <div class="col-md-4 col-ms-12">
                                    @if (($rol = auth()->user()->roles->first()->id) == 1)
                                        <form id="invoice" method="post"
                                            action="{{ route('invoices.update', $invoice) }}" autocomplete="off"
                                            class="form-horizontal" enctype="multipart/form-data">
                                            @method('put')
                                            @csrf
                                            @include('partials._invoicedata',[$rol])
                                        </form>
                                    @else
                                        @include('partials._invoicedata',[$rol])
                                    @endif
                                </div>
                                <div class="col-md-8 col-ms-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title"><strong>{{ __('Pagos del pedido') }}</strong></h4>
                                        </div>
                                        <div class="card-body">
                                            @if (auth()->user()->roles->first()->id == 1)
                                                <div class="row">
                                                    <div class="col-12 text-right">
                                                        <button type="button" class="btn btn-sm btn-primary"
                                                            data-toggle="modal"
                                                            data-target=".bd-example-modal-lg-register">{{ __('Agregar pago') }}</button>
                                                        @include('partials._paymentmodal',[$type='register'])
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="table-responsive">
                                                <table {{-- id="datatables" --}} class="table">
                                                    <thead class=" text-primary">
                                                        <th>{{ __('Cliente La Guerrera') }}</th>
                                                        <th>{{ __('La Guerrera Valero') }}</th>
                                                        <th>{{ __('Fletera') }}</th>
                                                        <th>{{ __('Fecha') }}</th>
                                                        @if (auth()->user()->roles->first()->id == 1)
                                                            <th class="text-right">{{ __('Acciones') }}</th>
                                                        @endif
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
                                                                @if (auth()->user()->roles->first()->id == 1)
                                                                    <td class="td-actions text-right">
                                                                        <button type="button"
                                                                            class="btn btn-success btn-link"
                                                                            data-toggle="modal"
                                                                            data-target=".bd-example-modal-lg-payment{{ $payment->id }}">
                                                                            <i class="material-icons">edit</i>
                                                                            <div class="ripple-container"></div>
                                                                        </button>
                                                                        @include('partials._paymentmodal',[$type="payment$payment->id"])
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @if (($rol = auth()->user()->roles->first()->id) == 1)
                                        <form method="post" action="{{ route('invoice', $invoice) }}" autocomplete="off"
                                            class="form-horizontal" enctype="multipart/form-data">
                                            @csrf
                                            @include('partials._invoice_data',[$rol])
                                        </form>
                                    @endif
                                    @if (($rol = auth()->user()->roles->first()->id) == 1)
                                        <form id="transportistaForm" action="{{ route('shipper', $invoice) }}"
                                            method="post" autocomplete="off" class="form-horizontal">
                                            @csrf
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">
                                                        <strong>{{ __('Facturación Transporte') }}</strong>
                                                    </h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row justify-content-center">
                                                        <div
                                                            class="form-group{{ $errors->has('shipper') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                                                            <label for="shipper">{{ __('Transportista') }}</label>
                                                            <input type="text"
                                                                class="form-control{{ $errors->has('shipper') ? ' is-invalid' : '' }}"
                                                                id="input-shipper" aria-describedby="shipperHelp"
                                                                placeholder="Escribe el nombre del transportista"
                                                                value="{{ old('shipper', $invoice->shipper) }}"
                                                                aria-required="true" name="shipper"
                                                                @if ($rol != 1) readonly @endif>
                                                            @if ($errors->has('shipper'))
                                                                <span id="shipper-error" class="error text-danger"
                                                                    for="input-shipper">
                                                                    {{ $errors->first('shipper') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="form-group{{ $errors->has('number_shipper') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                                                            <label
                                                                for="number_shipper">{{ __('Número de factura') }}</label>
                                                            <input type="text"
                                                                class="form-control{{ $errors->has('number_shipper') ? ' is-invalid' : '' }}"
                                                                id="input-number_shipper"
                                                                aria-describedby="number_shipperHelp"
                                                                placeholder="Escribe el número de factura"
                                                                value="{{ old('number_shipper', $invoice->number_shipper) }}"
                                                                aria-required="true" name="number_shipper" step="any"
                                                                @if ($rol != 1) readonly @endif>
                                                            @if ($errors->has('number_shipper'))
                                                                <span id="number_shipper-error" class="error text-danger"
                                                                    for="input-number_shipper">
                                                                    {{ $errors->first('number_shipper') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="form-group{{ $errors->has('invoice_shipper') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                                                            <label
                                                                for="invoice_shipper">{{ __('Cantidad Facturada') }}</label>
                                                            <input type="number"
                                                                class="form-control{{ $errors->has('invoice_shipper') ? ' is-invalid' : '' }}"
                                                                id="input-invoice_shipper"
                                                                aria-describedby="invoice_shipperHelp"
                                                                placeholder="Escribe la cantidad facturada"
                                                                value="{{ old('invoice_shipper', $invoice->invoice_shipper) }}"
                                                                aria-required="true" name="invoice_shipper" step="any"
                                                                @if ($rol != 1) readonly @endif>
                                                            @if ($errors->has('invoice_shipper'))
                                                                <span id="invoice_shipper-error" class="error text-danger"
                                                                    for="input-invoice_shipper">
                                                                    {{ $errors->first('invoice_shipper') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if ($rol == 1)
                                                        <div class="card-footer justify-content-center">
                                                            <button type="button" id="transportistaButton"
                                                                onclick="disabledButton('transportistaButton','transportistaForm')"
                                                                class="btn btn-primary">{{ __('Actualizar Facturación Transporte') }}
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-ms-12">
                                    <form id="creditForm" action="{{ route('credit', $invoice) }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="card ">
                                            <div class="card-header">
                                                <h4 class="card-title">
                                                    <strong>{{ __('Nota de crédito') }}</strong>
                                                </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row justify-content-center">
                                                    <div class="col-10 text-right">
                                                        @if ($invoice->creditpdf != null)
                                                            <a href="{{ route('download', [$invoice, 'creditpdf', 'pdf']) }}"
                                                                class="btn btn-sm btn-success">{{ __('Descargar pdf') }}</a>
                                                        @endif
                                                        @if ($invoice->creditxml != null)
                                                            <a href="{{ route('download', [$invoice, 'creditxml', 'xml']) }}"
                                                                class="btn btn-sm btn-success">{{ __('Descargar xml') }}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div
                                                        class="form-group{{ $errors->has('credit') ? ' has-danger' : '' }} col-md-5 col-sm-12">
                                                        <label for="credit">{{ __('Folio nota de crédito') }}</label>
                                                        <input type="text"
                                                            class="form-control{{ $errors->has('credit') ? ' is-invalid' : '' }}"
                                                            id="input-credit" aria-describedby="creditHelp"
                                                            placeholder="Escribe la nota de crédito"
                                                            value="{{ old('credit', $invoice->credit) }}"
                                                            aria-required="true" name="credit" @if ($rol != 1) readonly @endif>
                                                        @if ($errors->has('credit'))
                                                            <span id="credit-error" class="error text-danger"
                                                                for="input-credit">
                                                                {{ $errors->first('credit') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }} col-md-5 col-sm-12">
                                                        <label for="amount">{{ __('Importe final') }}</label>
                                                        <input type="text"
                                                            class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                                                            id="input-amount" aria-describedby="amountHelp"
                                                            placeholder="Escribe el importe final"
                                                            value="{{ old('amount', $invoice->amount) }}"
                                                            aria-required="true" name="amount" step="any"
                                                            @if ($rol != 1) readonly @endif>
                                                        @if ($errors->has('amount'))
                                                            <span id="amount-error" class="error text-danger"
                                                                for="input-amount">
                                                                {{ $errors->first('amount') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if ($rol == 1)
                                                    <div class="row justify-content-center">
                                                        <div class="col-md-5 col-sm-12">
                                                            <label>{{ __('Factura PDF') }}</label><br>
                                                            <input type="file" name="file_creditpdf" id="" accept=".pdf">
                                                            @if ($errors->has('file_creditpdf'))
                                                                <span id="text-file_creditpdf" class="error text-danger"
                                                                    for="input-file_creditpdf">
                                                                    <br> {{ $errors->first('file_creditpdf') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-5 col-sm-12">
                                                            <label>{{ __('Factura XML') }}</label><br>
                                                            <input type="file" name="file_creditxml" id="" accept=".xml">
                                                            @if ($errors->has('file_creditxml'))
                                                                <span id="text-file_creditxml" class="error text-danger"
                                                                    for="input-file_creditxml">
                                                                    <br> {{ $errors->first('file_creditxml') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="card-footer justify-content-center">
                                                        <button id="creditButton" type="button"
                                                            onclick="disabledButton('creditButton','creditForm')"
                                                            class="btn btn-primary">{{ __('Actualizar nota de crédito') }}
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
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
