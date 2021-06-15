@extends('layouts.app', ['activePage' => 'Validación de pedidos semanales', 'titlePage' => __('Validación de pedidos semanales')])

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
                            @include('partials._notification')
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="{{ route('pedidos.index') }}"
                                        class="btn btn-sm btn-success">{{ __('Realizar Pedido') }}</a>
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
                                            <a class="nav-link" href="#link3" data-toggle="tab">{{ __('Denegados') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content tab-space">
                                <div class="tab-pane active" id="link1" aria-expanded="true">
                                    <div class="table-responsive">
                                        <table class="table dataTable table-sm table-striped" cellspacing="0" width="100%"
                                            id="pendientes">
                                            @include('partials._pedidos',[$status=1])
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="link2" aria-expanded="false">
                                    <div class="row">
                                        <div class="col-12 text-right">
                                            <a href="{{ route('excel2') }}"
                                                class="btn btn-sm btn-primary">{{ __('Descargar Excel') }}</a>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table dataTable table-sm table-striped" cellspacing="0" width="100%"
                                            id="autorizados">
                                            @include('partials._pedidos',[$status=2])
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="link3" aria-expanded="false">
                                    <div class="table-responsive">
                                        <table class="table dataTable table-sm table-striped" cellspacing="0" width="100%"
                                            id="denegados">
                                            @include('partials._pedidos',[$status=3])
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
        $(document).ready(function() {
            loadTable('pendientes');
            loadTable('autorizados');
            loadTable('denegados');
        });

    </script>
@endpush
