@csrf
<div class="card ">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            <a href="{{ route('companies.index') }}" title="Volver a la lista de empresas">
                <span class="material-icons">arrow_back_ios</span>
            </a>
            {{ $title ?? __('Agregar empresa') }}
        </h4>
    </div>
    <div class="card-body">
        <div class="row justify-content-center mt-5">
            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                <label for="name">{{ __('Nombre') }}</label>
                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="input-name"
                    aria-describedby="nameHelp" placeholder="Escribe el nombre de la empresa"
                    value="{{ old('name', $company->name ?? '') }}" aria-required="true" name="name">
                @if ($errors->has('name'))
                    <span id="name-error" class="error text-danger" for="input-name">
                        {{ $errors->first('name') }}
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('rfc') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                <label for="rfc">{{ __('RFC') }}</label>
                <input type="text" class="form-control{{ $errors->has('rfc') ? ' is-invalid' : '' }}" name="rfc"
                    id="input-rfc" value="{{ old('rfc', $company->rfc ?? '') }}" aria-required="true"
                    aria-describedby="rfcHelp" placeholder='Escribe el RFC de la empresa' aria-required="true">
                @if ($errors->has('rfc'))
                    <span id="rfc-error" class="error text-danger" for="input-rfc">
                        {{ $errors->first('rfc') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('delivery_address') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                <label for="delivery_address">{{ __('Dirección de entrega') }}</label>
                <input type="text" class="form-control{{ $errors->has('delivery_address') ? ' is-invalid' : '' }}"
                    id="input-delivery_address" aria-describedby="delivery_addressHelp"
                    placeholder="Escribe la dirección de entrega de la empresa"
                    value="{{ old('delivery_address', $company->delivery_address ?? '') }}" aria-required="true"
                    name="delivery_address">
                @if ($errors->has('delivery_address'))
                    <span id="delivery_address-error" class="error text-danger" for="input-delivery_address">
                        {{ $errors->first('delivery_address') }}
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('fiscal_address') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                <label for="fiscal_address">{{ __('Dirección fiscal') }}</label>
                <input type="text" class="form-control{{ $errors->has('fiscal_address') ? ' is-invalid' : '' }}"
                    name="fiscal_address" id="input-fiscal_address"
                    value="{{ old('fiscal_address', $company->fiscal_address ?? '') }}" aria-required="true"
                    aria-describedby="fiscal_addressHelp" placeholder='Escribe la dirección fiscal de la empresa'
                    aria-required="true">
                @if ($errors->has('fiscal_address'))
                    <span id="fiscal_address-error" class="error text-danger" for="input-fiscal_address">
                        {{ $errors->first('fiscal_address') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('clabe') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                <label for="clabe">{{ __('CLABE') }}</label>
                <input type="text" class="form-control{{ $errors->has('clabe') ? ' is-invalid' : '' }}"
                    id="input-clabe" aria-describedby="clabeHelp" placeholder="Escribe el CLABE de la empresa"
                    value="{{ old('clabe', $company->clabe ?? '') }}" aria-required="true" name="clabe">
                @if ($errors->has('clabe'))
                    <span id="clabe-error" class="error text-danger" for="input-clabe">
                        {{ $errors->first('clabe') }}
                    </span>
                @endif
            </div>
            <div
                class="form-group{{ $errors->has('main') ? ' has-danger' : '' }} col-md-4 col-sm-12 checkbox-radios">
                <label class="label-control" for="main">{{ __('Activar como una empresa principal') }}</label>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="1" name="main" id="mainid" @if ($company->main ?? '' == 1) checked @endif>
                        {{ 'Activar' }}
                        <span class="form-check-sign">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
                @if ($errors->has('main'))
                    <span id="main-error" class="error text-danger" for="input-main">
                        {{ $errors->first('main') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div
                class="form-group{{ $errors->has('terminal_id') ? ' has-danger' : '' }} col-md-4 col-sm-12 checkbox-radios">
                <label for="terminal_id">{{ __('Elije las terminales de la empresa') }}</label>
                @foreach ($terminals as $terminal)
                    <div class="form-check mt-3">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" value="{{ $terminal->id }}"
                                name="terminal_id[]" @if ($terminal->companies->contains($company->id ?? '')) checked @endif>
                            {{ $terminal->name }}
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                        </label>
                    </div>
                @endforeach
                @if ($errors->has('terminal_id'))
                    <span id="terminal_id-error" class="error text-danger" for="input-terminal_id">
                        {{ $errors->first('terminal_id') }}
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="card-footer ml-auto mr-auto">
        <button type="submit" class="btn btn-primary">{{ $button ?? __('Registrar') }}</button>
    </div>
</div>
