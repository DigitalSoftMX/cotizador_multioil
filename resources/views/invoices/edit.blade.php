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
                            {{-- datos del pedidos --}}
                            @include('invoices.dataorder')
                            {{-- CRUD comision --}}
                            @include('invoices.comission')
                            {{-- Pagos del pedido --}}
                            @include('invoices.payments')
                            <div class="row">
                                {{-- Datos de facturación --}}
                                <div class="col-md-5 col-ms-12">
                                    @if (($rol = auth()->user()->roles->first()->id) == 1)
                                        <form id="invoice" method="post" action="{{ route('invoices.update', $invoice) }}"
                                            autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                                            @method('put')
                                            @csrf
                                            @include('invoices.invoiceData',[$rol])
                                        </form>
                                    @else
                                        @include('invoices.invoiceData',[$rol])
                                    @endif
                                </div>
                                <div class="col-md-7 col-ms-12">
                                    {{-- Facturacion Valero - Guerrera --}}
                                    @include('invoices.invoiceValeroGuerrera',[$rol])
                                    {{-- Facturacion transporte --}}
                                    @include('invoices.invoiceTransport')
                                    {{-- Notas de crédito --}}
                                    @include('invoices.creditnotes')
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
