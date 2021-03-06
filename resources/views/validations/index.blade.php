@extends('layouts.app', ['activePage' => 'Validación de pedidos', 'titlePage' => __('Validación de pedidos')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Pedidos') }}</h4>
                            <p class="card-category"> {{ __('Aquí puedes administrar los pedidos solicitados.') }}</p>
                        </div>
                        <div class="card-body">
                            @include('partials.notification')
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <a href="{{ route('orders.index') }}"
                                        class="btn btn-sm btn-success">{{ __('Realizar Pedido') }}</a>
                                </div>
                            </div>

                            <div class="row justify-content-md-start ml-1">
                                <div class="form-group col-sm-3">

                                    <select id="input-month_id" name="month_id" class="time selectpicker show-menu-arrow"
                                        data-style="btn-primary" data-width="100%" data-live-search="true">

                                        @foreach ($months as $m)
                                            <option value="{{ $m['id'] }}"
                                                @if ($month == $m['id']) selected @endif>
                                                {{ $m['name'] }}

                                            </option>
                                        @endforeach

                                    </select>

                                </div>

                                <div class="form-group col-sm-3">
                                    <select id="input-year_id" name="year_id" class="time selectpicker show-menu-arrow"
                                        data-style="btn-primary" data-width="100%" data-live-search="true">

                                        @foreach ($years as $y)
                                            <option value="{{ $y }}"
                                                @if ($year == $y) selected @endif>
                                                {{ $y }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="nav-tabs-navigation">
                                <div class="nav-tabs-wrapper">
                                    <ul class="nav nav-pills nav-justified" data-tabs="tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#link1"
                                                data-toggle="tab">{{ __('Pendientes') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#link2"
                                                data-toggle="tab">{{ __('Autorizados') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#link3"
                                                data-toggle="tab">{{ __('Denegados') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content tab-space">
                                <div class="tab-pane active" id="link1" aria-expanded="true">

                                    <div class="table-responsive">
                                        <table class="table dataTable table-sm table-striped" cellspacing="0" width="100%"
                                            id="pendientes">
                                            @include('partials._orders',[$status=1])
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="link2" aria-expanded="false">

                                    @if (auth()->user()->roles->first()->id == 1)
                                        <div class="row justify-content-end">
                                            <div class="text-right">
                                                <a href="{{ route('excel') }}"
                                                    class="btn btn-sm btn-primary">{{ __('Excel Pedidos diarios') }}</a>
                                            </div>
                                            <div class="text-right">
                                                <a href="{{ route('sales') }}"
                                                    class="btn btn-sm btn-primary">{{ __('Excel Ventas') }}</a>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="table-responsive">
                                        <table class="table dataTable table-sm table-striped" cellspacing="0" width="100%"
                                            id="autorizados">
                                            @include('partials._orders',[$status=2])
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="link3" aria-expanded="false">
                                    <div class="table-responsive">
                                        <table class="table dataTable table-sm table-striped" cellspacing="0" width="100%"
                                            id="denegados">
                                            @include('partials._orders',[$status=3])
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
@endsection
@push('js')
    <script src="{{ asset('js/ventas.js') }}"></script>
    <script>
        loadTable('pendientes');
        loadTable('autorizados');
        loadTable('denegados');

        $(".time").change(function() {
            const month = document.getElementById('input-month_id').value;
            const year = document.getElementById('input-year_id').value;
            window.location = `{{ url('/validations/${month}/${year}') }}`;
        });
    </script>
@endpush
