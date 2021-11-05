@extends('layouts.app', ['activePage' => 'Empresas', 'titlePage' => __('Gestión de empresas')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">
                                {{ __('Empresas') }}
                            </h4>
                            <p class="card-category">
                                {{ __('Aquí puedes gestionar las empresas.') }}
                            </p>
                        </div>
                        <div class="card-body">
                            @include('partials._notification')
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a class="btn btn-sm btn-primary" href="{{ route('companies.create') }}">
                                        {{ __('Agregar Empresa') }}
                                    </a>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <table cellspacing="0" class="table table-striped table-no-bordered table-hover"
                                    id="datatables" style="width:100%" width="100%">
                                    <thead class="text-primary">
                                        <th>{{ __('Nombre') }}</th>
                                        <th>{{ __('RFC') }}</th>
                                        <th>{{ __('Dirección de entrega') }}</th>
                                        <th>{{ __('Correo electrónico') }}</th>
                                        <th>{{ __('# Terminales') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Fecha de Alta') }}</th>
                                        <th>{{ __('Acciones') }}</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($companies as $company)
                                            <tr class="{{ $company->main ? 'table-success' : '' }}">
                                                <td>{{ $company->name }}</td>
                                                <td>{{ $company->rfc }}</td>
                                                <td>{{ $company->delivery_address }}</td>
                                                <td>{{ $company->email }}</td>
                                                <td>{{ $company->terminals->count() }}</td>
                                                <td>{{ $company->active == '1' ? 'Activo' : 'Inactivo' }}</td>
                                                <td>{{ $company->created_at->format('Y/m/d') }}</td>
                                                <td class="td-actions">
                                                    <form action="{{ route('companies.destroy', $company) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <div class="row justify-content-end">
                                                            <a rel="tooltip" class="btn btn-dark btn-link"
                                                                href="{{ route('getshopping', $company) }}">
                                                                <i class="material-icons">visibility</i>
                                                                <div class="ripple-container"></div>
                                                            </a>
                                                            <a rel="tooltip" class="btn btn-success btn-link"
                                                                href="{{ route('companies.edit', $company) }}">
                                                                <i class="material-icons">edit</i>
                                                                <div class="ripple-container"></div>
                                                            </a>
                                                            <button type="submit" class="btn btn-danger btn-link"                                                               
                                                                onclick="confirm('{{ __('¿Estás seguro de que deseas eliminar a esta empresa?') }}') ? this.parentElement.submit() : ''">
                                                                <i class="material-icons">close</i>
                                                                <div class="ripple-container"></div>
                                                            </button>
                                                        </div>
                                                    </form>
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
@endsection
@push('js')
    <script src="{{ asset('js/ventas.js') }}"></script>
    <script>
        $(document).ready(function() {
            loadTable('datatables');
        });
    </script>
@endpush
