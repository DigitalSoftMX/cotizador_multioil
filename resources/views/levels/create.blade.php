@extends('layouts.app', ['activePage' => 'Flete', 'titlePage' => __('Relacion entre unidad - kms - precios')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">
                                <a href="{{ route('levels.index') }}"
                                    title="Volver al cálculo de costo aproximado de flete">
                                    <span class="material-icons">arrow_back_ios</span>
                                </a>
                                {{ __('Relacion entre unidad - kms - precios') }}
                            </h4>
                            <p class="card-category">
                                {{ __('Aquí puedes administrar la relación entre unidad - kms - precio.') }}</p>
                        </div>
                        <div class="card-body">
                            @include('partials._notification')
                            <div class="row">
                                <div class="col-12 text-right">
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#register">
                                        {{ __('Agregar una unidad-km-precio') }}
                                    </button>
                                </div>
                                @include('partials._modallevels')
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <select id="input-truck" class="selectpicker show-menu-arrow" data-style="btn-primary"
                                        data-width="100%" data-live-search="true">
                                        <option value="0" selected>{{ __('Todas las unidades') }}</option>
                                        <option value="1">{{ __('Pipa (20,000 lts)') }}</option>
                                        <option value="2">{{ __('Sencillo (31,000 lts)') }}</option>
                                        <option value="3">{{ __('Full (62,000 lts)') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-9 col-sm-12">
                                    <div class="table-responsive">
                                        <table id="datatables" class="table">
                                            <thead class="text-center text-primary">
                                                <th>{{ __('Unidad') }}</th>
                                                <th>{{ __('Kilometros') }}</th>
                                                <th>{{ __('Precio') }}</th>
                                                <th>{{ __('Fecha de Alta') }}</th>
                                                <th class="text-right">{{ __('Acciones') }}</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($levels as $level)
                                                    <tr class="text-center">
                                                        <td>
                                                            @switch($level->truck_id)
                                                                @case(1)
                                                                    {{ __('Pipa (20,000 lts)') }}
                                                                @break
                                                                @case(2)
                                                                    {{ __('Sencillo (31,000 lts)') }}
                                                                @break
                                                                @case(3)
                                                                    {{ __('Full (62,000 lts)') }}
                                                                @break
                                                                @default
                                                                    {{ __('Sin unidad') }}
                                                            @endswitch
                                                        </td>
                                                        <td>{{ $level->kms }} kms</td>
                                                        <td>$ {{ $level->price }}</td>
                                                        <td>{{ $level->created_at->format('Y/m/d') }}</td>
                                                        <td class="td-actions text-right">
                                                            <form action="{{ route('levels.destroy', $level) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <a rel="tooltip" class="btn btn-success btn-link"
                                                                    href="{{ route('levels.edit', $level) }}"
                                                                    data-original-title="" title="">
                                                                    <i class="material-icons">edit</i>
                                                                    <div class="ripple-container"></div>
                                                                </a>
                                                                <button type="button" class="btn btn-danger btn-link"
                                                                    data-original-title="" title=""
                                                                    onclick="confirm('{{ __('¿Estás seguro de que deseas eliminar a este nivel?') }}') ? this.parentElement.submit() : ''">
                                                                    <i class="material-icons">close</i>
                                                                    <div class="ripple-container"></div>
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
