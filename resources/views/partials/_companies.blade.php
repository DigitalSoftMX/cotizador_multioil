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
            <div class="form-group{{ $errors->has('alias') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                <label for="alias">{{ __('alias') }}</label>
                <input type="text" class="form-control{{ $errors->has('alias') ? ' is-invalid' : '' }}" name="alias"
                    id="input-alias" value="{{ old('alias', $company->alias ?? '') }}" aria-required="true"
                    aria-describedby="aliasHelp" placeholder='Escribe el alias de la empresa' aria-required="true">
                @if ($errors->has('alias'))
                    <span id="alias-error" class="error text-danger" for="input-alias">
                        {{ $errors->first('alias') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
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
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                <label for="email">{{ __('Correo electrónico') }}</label>
                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                    id="input-email" value="{{ old('email', $company->email ?? '') }}" aria-required="true"
                    aria-describedby="emailHelp" placeholder='Escribe el correo electrónico de la empresa'
                    aria-required="true">
                @if ($errors->has('email'))
                    <span id="email-error" class="error text-danger" for="input-email">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('color') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                <label for="color">{{ __('Color representativo de la empresa') }}</label>
                <div class="row">
                    <div class="col-4">
                        <input type="color"
                            class="form-control{{ $errors->has('color') ? ' is-invalid' : '' }} col mt-4"
                            id="input-color" aria-describedby="colorHelp" placeholder="Escribe el color de la empresa"
                            value="{{ old('color', $company->color ?? '') }}" aria-required="true" name="color">
                        @if ($errors->has('color'))
                            <span id="color-error" class="error text-danger" for="input-color">
                                {{ $errors->first('color') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
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
