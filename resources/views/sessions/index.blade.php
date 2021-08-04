@extends('layouts.app', ['activePage' => 'Historial sesiones', 'titlePage' => __('Historial de inicio de sesión')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Usuarios') }}</h4>
                            <p class="card-category"> {{ __('Aquí puedes ver a los usuarios que han iniciado sesión.') }}
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatables" class="table">
                                    <thead class=" text-primary">
                                        <th>{{ __('Nombre') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Teléfono') }}</th>
                                        <th>{{ __('Rol') }}</th>
                                        <th>{{ __('Fecha') }}</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($logins as $login)
                                            <tr>
                                                <td>{{ $login->user->name }} {{ $login->user->app_name }}
                                                    {{ $login->user->apm_name }}
                                                </td>
                                                <td>{{ $login->user->email }}</td>
                                                <td>{{ $login->user->phone }}</td>
                                                <td>{{ $login->user->roles()->first()->name ?? '' }}</td>
                                                <td>{{ $login->created_at->format('Y/m/d H:i') }}</td>
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
