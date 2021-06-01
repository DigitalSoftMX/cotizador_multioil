
@extends('layouts.app', ['activePage' => 'Fee', 'titlePage' => __('Fee')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Fee') }}</h4>
                            <p class="card-category">
                                {{ __('Aquí puedes administrar todos los Fee de las terminales.') }}
                            </p>
                        </div>
                        <div class="card-body">
                            @include('partials._notification')
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a class="btn btn-sm btn-primary"
                                        href="{{ route('fits.create') }}">{{ __('Agregar Fee') }}
                                    </a>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <table cellspacing="0" class="table table-striped table-no-bordered table-hover"
                                    id="datatables" style="width:100%" width="100%">
                                    <thead class="text-primary">
                                        <th>{{ __('Empresa') }}</th>
                                        <th>{{ __('Terminal') }}</th>
                                        <th>{{ __('Comision') }}</th>
                                        <th>{{ __('Regular Fee') }}</th>
                                        <th>{{ __('Premium Fee') }}</th>
                                        <th>{{ __('Diesel Fee') }}</th>
                                        <th>{{ __('Fecha de Alta') }}</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($fees as $fee)
                                            <tr>
                                                <td>{{ $fee->companies->name ?? '' }}</td>
                                                <td>{{ $fee->terminals->business_name }}</td>
                                                <td>$ {{ $fee->commission }}</td>
                                                <td>$ {{ $fee->regular_fit }}</td>
                                                <td>$ {{ $fee->premium_fit }}</td>
                                                <td>$ {{ $fee->diesel_fit }}</td>
                                                <td>{{ $fee->created_at->format('Y/m/d') }}</td>
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
@endsection
@push('js')
    <script src="{{ asset('js/ventas.js') }}"></script>
    <script>
        $(document).ready(function() {
            loadTable('datatables');
        });

    </script>
@endpush
