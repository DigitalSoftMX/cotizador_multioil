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
                                    <h5><strong>{{ __('Datos del pedido:') }}</strong></h5>
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
                                                                            {{ __('Elija un vendedor') }}
                                                                        </option>
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
                            @endif
                            <div class="row">
                                <div class="col-md-4 col-ms-12">
                                    @if (($rol = auth()->user()->roles->first()->id) == 1)
                                        <form method="post" action="{{ route('invoices.update', $invoice) }}"
                                            autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
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
                                                            data-target=".bd-example-modal-lg-payment">{{ __('Agregar pago') }}</button>
                                                        @include('partials._paymentmodal',[$type='payment'])
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="table-responsive">
                                                <table id="datatables" class="table">
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
                                                                        @include('partials._paymentmodal',[$type='payment'.$payment->id])
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
                                        <form method="post" action="{{ route('invoice', $invoice) }}"
                                            autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                                            @csrf
                                            @include('partials._invoice_data',[$rol])
                                        </form>
                                    @else
                                        @include('partials._invoice_data',[$rol])
                                    @endif
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
