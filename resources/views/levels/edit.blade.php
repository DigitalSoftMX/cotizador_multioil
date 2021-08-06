@extends('layouts.app', ['activePage' => 'Flete', 'titlePage' => __('Relacion entre unidad - kms - precios')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('levels.update', $level) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">
                                    <a href="{{ route('levels.create') }}"
                                        title="Volver a la lista de unidades kms precio">
                                        <span class="material-icons">arrow_back_ios</span>
                                    </a>
                                    {{ __('Editar la unidad - kms - precios') }}
                                </h4>
                                <p class="card-category">
                                    {{ __('Aquí puedes administrar la relación entre unidad - kms - precio.') }}</p>
                            </div>
                            <div class="card-body">
                                @include('partials._notification')

                                <div class="row justify-content-center">
                                    <div
                                        class="form-group{{ $errors->has('truck_id') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                                        <select id="input-truck_id" name="truck_id"
                                            class="selectpicker show-menu-arrow {{ $errors->has('truck_id') ? ' has-danger' : '' }}"
                                            data-style="btn-primary" data-width="100%" data-live-search="true" required>
                                            <option value="" disabled selected>{{ __('Elija un unidad') }}
                                            </option>
                                            <option value="1" @if (($l = $level->truck_id) == 1) selected @endif>
                                                {{ __('Pipa (20,000 lts)') }}
                                            </option>
                                            <option value="2" @if (($l = $level->truck_id) == 2) selected @endif>
                                                {{ __('Sencillo (31,000 lts)') }}
                                            </option>
                                            <option value="3" @if (($l = $level->truck_id) == 3) selected @endif>
                                                {{ __('Full (62,000 lts)') }}
                                            </option>
                                        </select>
                                        @if ($errors->has('truck_id'))
                                            <span id="name-truck_id" class="error text-danger"
                                                for="input-truck_id">{{ $errors->first('truck_id') }}</span>
                                        @endif
                                    </div>
                                    <div
                                        class="form-group{{ $errors->has('kms') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                                        <label for="kms">{{ __('Kilómetros') }}</label>
                                        <input type="number"
                                            class="form-control{{ $errors->has('kms') ? ' is-invalid' : '' }}"
                                            id="input-kms" aria-describedby="kmsHelp"
                                            placeholder="Escribe la cantidad de kms"
                                            value="{{ old('kms', $level->kms ?? '') }}" aria-required="true" name="kms"
                                            type="any" required>
                                        @if ($errors->has('kms'))
                                            <span id="kms-error" class="error text-danger" for="input-kms">
                                                {{ $errors->first('kms') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div
                                        class="form-group{{ $errors->has('price') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                                        <label for="price">{{ __('$ Precio') }}</label>
                                        <input type="number"
                                            class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}"
                                            id="input-price" aria-describedby="priceHelp" placeholder="Escribe el precio"
                                            value="{{ old('price', $level->price ?? '') }}" aria-required="true"
                                            name="price" type="any" required>
                                        @if ($errors->has('price'))
                                            <span id="price-error" class="error text-danger" for="input-price">
                                                {{ $errors->first('price') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <button type="submit" class="btn btn-primary">{{ 'Actualizar' }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
