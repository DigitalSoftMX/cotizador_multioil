@extends('layouts.app', ['activePage' => 'Usuarios', 'titlePage' => __('Gestión de usuarios')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Usuarios') }}</h4>
                            <p class="card-category"> {{ __('Aquí puedes administrar a los usuarios.') }}</p>
                        </div>
                        <div class="card-body">
                            @include('partials._notification')
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="{{ route('users.create') }}"
                                        class="btn btn-sm btn-primary">{{ __('Agregar Usuario') }}</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="datatables" class="table">
                                    <thead class=" text-primary">
                                        <th>{{ __('Nombre') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Rol') }}</th>
                                        <th>{{ __('Fecha de Alta') }}</th>
                                        <th class="text-right">{{ __('Acciones') }}</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->name }} {{ $user->app_name }} {{ $user->apm_name }}
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->roles()->first()->name }}</td>
                                                <td>
                                                    {{ $user->created_at->format('Y-m-d') }}
                                                </td>
                                                <td class="td-actions text-right">
                                                    @if ($user->id != auth()->id())
                                                        <form action="{{ route('users.destroy', $user) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <a rel="tooltip" class="btn btn-success btn-link"
                                                                href="{{ route('users.edit', $user) }}"
                                                                data-original-title="" title="">
                                                                <i class="material-icons">edit</i>
                                                                <div class="ripple-container"></div>
                                                            </a>
                                                            <button type="button" class="btn btn-danger btn-link"
                                                                data-original-title="" title=""
                                                                onclick="confirm('{{ __('¿Estás seguro de que deseas eliminar a este usuario?') }}') ? this.parentElement.submit() : ''">
                                                                <i class="material-icons">close</i>
                                                                <div class="ripple-container"></div>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <a rel="tooltip" class="btn btn-success btn-link"
                                                            href="{{ route('profile.edit') }}" data-original-title=""
                                                            title="">
                                                            <i class="material-icons">edit</i>
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                    @endif
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
