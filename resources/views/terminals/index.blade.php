@extends('layouts.app', ['activePage' => 'Terminales', 'titlePage' => __('Alta de Terminales')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Terminales') }}</h4>
                            <p class="card-category">{{ __('Aquí puedes administrar todas las terminales.') }}</p>
                        </div>
                        <div class="card-body">
                            @include('partials._notification')
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a class="btn btn-sm btn-primary" href="{{ route('terminals.create') }}">
                                        {{ __('Agregar Terminal') }}
                                    </a>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <table cellspacing="0" class="table table-striped table-no-bordered table-hover"
                                    id="datatables" style="width:100%" width="100%">
                                    <thead class="text-primary">
                                        <th>{{ __('Nombre') }}</th>
                                        <th>{{ __('RFC') }}</th>
                                        <th>{{ __('Municipio') }}</th>
                                        <th>{{ __('Estado') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Fecha de Alta') }}</th>
                                        <th class="disabled-sorting text-right">{{ __('Acciones') }}</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($terminals as $terminal)
                                            <tr>
                                                <td>{{ $terminal->business_name }}</td>
                                                <td>{{ $terminal->rfc }}</td>
                                                <td>{{ $terminal->location }}</td>
                                                <td>{{ $terminal->state }}</td>
                                                <td>{{ $terminal->status == 1 ? 'Activa' : 'Inactiva' }}</td>
                                                <td>{{ $terminal->created_at->format('Y/m/d') }}</td>
                                                <td class="td-actions text-right">
                                                    <form action="{{ route('terminals.destroy', $terminal) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <a class="btn btn-success btn-link" data-original-title=""
                                                            href="{{ route('terminals.edit', $terminal) }}" rel="tooltip"
                                                            title="">
                                                            <i class="material-icons"> edit</i>
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-link"
                                                            data-original-title="" title=""
                                                            onclick="confirm('{{ __('¿Estás seguro de que deseas eliminar a esta Terminal?') }}') ? this.parentElement.submit() : ''">
                                                            <i class="material-icons">close</i>
                                                        </button>
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
