@extends('layouts.app', ['activePage' => 'Flete', 'titlePage' => __('Gestión de niveles km - precios')])

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
                                {{ __('Niveles km - precio') }}
                            </h4>
                            <p class="card-category"> {{ __('Aquí puedes administrar a los niveles km - precio.') }}</p>
                        </div>
                        <div class="card-body">
                            @include('partials._notification')
                            <div class="row justify-content-center">
                                <div class="col-8">
                                    <form method="post" action="{{ route($route ?? 'levels.store', $l ?? '') }}"
                                        autocomplete="off" class="form-horizontal">
                                        @csrf
                                        @method($method??'post')
                                        <div class="row justify-content-center">
                                            <h4 class="card-category">{{ __('Registro de kilometro - precio') }}</h4>
                                        </div>
                                        <div class="row">
                                            <div class="form-group{{ $errors->has('kms') ? ' has-danger' : '' }} col-6">
                                                <label for="kms">{{ __('Kilometros') }}</label>
                                                <input type="number"
                                                    class="form-control{{ $errors->has('kms') ? ' is-invalid' : '' }}"
                                                    id="input-kms" aria-describedby="kmsHelp"
                                                    placeholder="Escribe el límite en kilometros"
                                                    value="{{ old('kms', $l->kms ?? '') }}" aria-required="true"
                                                    name="kms" step="any">
                                                @if ($errors->has('kms'))
                                                    <span id="kms-error" class="error text-danger" for="input-kms">
                                                        {{ $errors->first('kms') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div
                                                class="form-group{{ $errors->has('price') ? ' has-danger' : '' }} col-6">
                                                <label for="price">{{ __('Precio') }}</label>
                                                <input type="number"
                                                    class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}"
                                                    name="price" id="input-price"
                                                    value="{{ old('price', $l->price ?? '') }}" aria-required="true"
                                                    aria-describedby="priceHelp"
                                                    placeholder='Escribe el precio por kilometro' aria-required="true"
                                                    step="any">
                                                @if ($errors->has('price'))
                                                    <span id="price-error" class="error text-danger" for="input-price">
                                                        {{ $errors->first('price') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <button type="submit"
                                                class="btn btn-primary">{{ isset($l) ? 'Actualizar' : 'Registrar' }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            {{-- formulario para agregar nuevo nivel --}}
                            <div class="row justify-content-center mt-5">
                                <div class="col-8">
                                    <div class="table-responsive">
                                        <table id="datatables" class="table">
                                            <thead class=" text-primary">
                                                <th>{{ __('Kilometros') }}</th>
                                                <th>{{ __('Precio') }}</th>
                                                <th>{{ __('Fecha de Alta') }}</th>
                                                <th class="text-right">{{ __('Acciones') }}</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($levels as $level)
                                                    <tr @if (($l->id ?? '') == $level->id) class="table-success" @endif>
                                                        <td>{{ $level->kms }} kms</td>
                                                        <td>$ {{ $level->price }}</td>
                                                        <td>{{ $level->created_at->format('Y/m/d') }}</td>
                                                        @if (($l->id ?? '') != $level->id)
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
                                                        @else
                                                            <td></td>
                                                        @endif
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
