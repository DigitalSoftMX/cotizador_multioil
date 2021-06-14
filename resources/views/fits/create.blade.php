@extends('layouts.app', ['activePage' => 'Fee', 'titlePage' => __('Fee')])

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('fits.store') }}" autocomplete="off" class="form-horizontal" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">
                                    <a href="{{ route('fits.index') }}" title="Volver a la lista de FEE">
                                        <span class="material-icons">arrow_back_ios</span>
                                    </a>
                                    {{ $title ?? __('Agregar FEE') }}
                                </h4>
                            </div>
                            <div class="card-body mt-5">
                               
                                    <div
                                        class="form-group{{ $errors->has('terminal_id') ? ' has-danger' : '' }} col-sm-3">
                                        <select id="input-terminal_id" name="terminal_id"
                                            class="selectpicker show-menu-arrow {{ $errors->has('terminal_id') ? ' has-danger' : '' }}"
                                            data-style="btn-primary" data-width="100%" data-live-search="true">
                                            <option value="">{{ __('Elija una terminal') }}</option>
                                            @foreach ($terminals as $terminal)
                                                <option value="{{ $terminal->id }}">{{ $terminal->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('terminal_id'))
                                            <span id="name-terminal_id" class="error text-danger"
                                                for="input-terminal_id">{{ $errors->first('terminal_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('company_id') ? ' has-danger' : '' }} col-sm-3">
                                        <select id="input-company_id" name="company_id"
                                            class="selectpicker show-menu-arrow {{ $errors->has('company_id') ? ' has-danger' : '' }}"
                                            data-style="btn-primary" data-width="100%" data-live-search="true">
                                            <option value="">{{ __('Elija una empresa') }}</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}">{{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('company_id'))
                                            <span id="name-company_id" class="error text-danger"
                                                for="input-company_id">{{ $errors->first('company_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="form-group{{ $errors->has('commission') ? ' has-danger' : '' }} col">
                                        <label for="commission">{{ __('Comisión') }}</label>
                                        <input type="number" step="0.01"
                                            class="form-control{{ $errors->has('commission') ? ' is-invalid' : '' }}"
                                            id="input-commission" placeholder="0" aria-describedby="commissionHelp"
                                            value="{{ old('commission') }}" required="true" name="commission">
                                        @if ($errors->has('commission'))
                                            <span id="commission-error" class="error text-danger" for="input-commission">
                                                {{ $errors->first('commission') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('regular_fit') ? ' has-danger' : '' }} col">
                                        <label for="regular_fit">{{ __('Regular FEE') }}</label>
                                        <input type="number" step="0.01"
                                            class="form-control{{ $errors->has('regular_fit') ? ' is-invalid' : '' }}"
                                            id="input-regular_fit" placeholder="0" aria-describedby="regular_fitHelp"
                                            value="{{ old('regular_fit') }}" required="true" name="regular_fit">
                                        @if ($errors->has('regular_fit'))
                                            <span id="regular_fit-error" class="error text-danger" for="input-regular_fit">
                                                {{ $errors->first('regular_fit') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('premium_fit') ? ' has-danger' : '' }} col">
                                        <label for="premium_fit">{{ __('Premium FEE') }}</label>
                                        <input type="number" step="0.01"
                                            class="form-control{{ $errors->has('premium_fit') ? ' is-invalid' : '' }}"
                                            id="input-premium_fit" placeholder="0" aria-describedby="premium_fitHelp"
                                            value="{{ old('premium_fit') }}" required="true" name="premium_fit">
                                        @if ($errors->has('premium_fit'))
                                            <span id="premium_fit-error" class="error text-danger" for="input-premium_fit">
                                                {{ $errors->first('premium_fit') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('diesel_fit') ? ' has-danger' : '' }} col">
                                        <label for="diesel_fit">{{ __('Diésel FEE') }}</label>
                                        <input type="number" step="0.01"
                                            class="form-control{{ $errors->has('diesel_fit') ? ' is-invalid' : '' }}"
                                            id="input-diesel_fit" placeholder="0" aria-describedby="diesel_fitHelp"
                                            value="{{ old('diesel_fit') }}" required="true" name="diesel_fit">
                                        @if ($errors->has('diesel_fit'))
                                            <span id="diesel_fit-error" class="error text-danger" for="input-diesel_fit">
                                                {{ $errors->first('diesel_fit') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-primary">{{ $button ?? __('Registrar') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
