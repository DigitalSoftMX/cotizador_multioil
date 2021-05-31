@csrf
<div class="card ">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            <a href="{{ route('terminals.index') }}" title="Volver a la lista de terminales">
                <span class="material-icons">arrow_back_ios</span>
            </a>
            {{ $title ?? __('Agregar terminal') }}
        </h4>
    </div>
    <div class="card-body mt-5">
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('business_name') ? ' has-danger' : '' }} col-sm-5">
                <label for="business_name">{{ __('Razón social') }}</label>
                <input type="text" class="form-control{{ $errors->has('business_name') ? ' is-invalid' : '' }}"
                    id="input-business_name" aria-describedby="business_nameHelp"
                    placeholder="Escribe la razon social de la terminal"
                    value="{{ old('business_name', $terminal->business_name ?? '') }}" aria-required="true"
                    name="business_name">
                @if ($errors->has('business_name'))
                    <span id="business_name-error" class="error text-danger" for="input-business_name">
                        {{ $errors->first('business_name') }}
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('rfc') ? ' has-danger' : '' }} col-sm-5">
                <label for="rfc">{{ __('RFC') }}</label>
                <input type="text" class="form-control{{ $errors->has('rfc') ? ' is-invalid' : '' }}" name="rfc"
                    id="input-rfc" value="{{ old('rfc', $terminal->rfc ?? '') }}" aria-required="true"
                    aria-describedby="rfcHelp" placeholder='Escribe el RFC de la terminal' aria-required="true">
                @if ($errors->has('rfc'))
                    <span id="rfc-error" class="error text-danger" for="input-rfc">
                        {{ $errors->first('rfc') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }} col-sm-5">
                <label for="name">{{ __('Nombre') }}</label>
                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                    id="input-name" aria-describedby="nameHelp" placeholder="Escribe el nombre de la terminal"
                    value="{{ old('name', $terminal->name ?? '') }}" aria-required="true" name="name">
                @if ($errors->has('name'))
                    <span id="name-error" class="error text-danger" for="input-name">
                        {{ $errors->first('name') }}
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('postcode') ? ' has-danger' : '' }} col-sm-5">
                <label for="postcode">{{ __('Código postal') }}</label>
                <input type="number" class="form-control{{ $errors->has('postcode') ? ' is-invalid' : '' }}"
                    name="postcode" id="input-postcode" value="{{ old('postcode', $terminal->postcode ?? '') }}"
                    aria-required="true" aria-describedby="postcodeHelp"
                    placeholder='Escribe el código postal de la terminal' aria-required="true">
                @if ($errors->has('postcode'))
                    <span id="postcode-error" class="error text-danger" for="input-postcode">
                        {{ $errors->first('postcode') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('kind_road') ? ' has-danger' : '' }} col-sm-5">
                <label for="kind_road">{{ __('Tipo de vialidad') }}</label>
                <input type="text" class="form-control{{ $errors->has('kind_road') ? ' is-invalid' : '' }}"
                    id="input-kind_road" aria-describedby="kind_roadHelp" placeholder="Escribe el tipo de vialidad"
                    value="{{ old('kind_road', $terminal->kind_road ?? '') }}" aria-required="true" name="kind_road">
                @if ($errors->has('kind_road'))
                    <span id="kind_road-error" class="error text-danger" for="input-kind_road">
                        {{ $errors->first('kind_road') }}
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('name_road') ? ' has-danger' : '' }} col-sm-5">
                <label for="name_road">{{ __('Nombre de la vialidad') }}</label>
                <input type="text" class="form-control{{ $errors->has('name_road') ? ' is-invalid' : '' }}"
                    name="name_road" id="input-name_road" value="{{ old('name_road', $terminal->name_road ?? '') }}"
                    aria-required="true" aria-describedby="name_roadHelp" placeholder='Escribe el nombre de la vialidad'
                    aria-required="true">
                @if ($errors->has('name_road'))
                    <span id="name_road-error" class="error text-danger" for="input-name_road">
                        {{ $errors->first('name_road') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('n_inside') ? ' has-danger' : '' }} col-sm-5">
                <label for="n_inside">{{ __('Número interior') }}</label>
                <input type="number" class="form-control{{ $errors->has('n_inside') ? ' is-invalid' : '' }}"
                    id="input-n_inside" aria-describedby="n_insideHelp" placeholder="Escribe el número interior"
                    value="{{ old('n_inside', $terminal->n_inside ?? '') }}" aria-required="true" name="n_inside">
                @if ($errors->has('n_inside'))
                    <span id="n_inside-error" class="error text-danger" for="input-n_inside">
                        {{ $errors->first('n_inside') }}
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('n_outsice') ? ' has-danger' : '' }} col-sm-5">
                <label for="n_outsice">{{ __('Número exterior') }}</label>
                <input type="number" class="form-control{{ $errors->has('n_outsice') ? ' is-invalid' : '' }}"
                    name="n_outsice" id="input-n_outsice" value="{{ old('n_outsice', $terminal->n_outsice ?? '') }}"
                    aria-required="true" aria-describedby="n_outsiceHelp" placeholder='Escribe el número exterior'
                    aria-required="true">
                @if ($errors->has('n_outsice'))
                    <span id="n_outsice-error" class="error text-danger" for="input-n_outsice">
                        {{ $errors->first('n_outsice') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('settlement') ? ' has-danger' : '' }} col-sm-5">
                <label for="settlement">{{ __('Colonia') }}</label>
                <input type="text" class="form-control{{ $errors->has('settlement') ? ' is-invalid' : '' }}"
                    id="input-settlement" aria-describedby="settlementHelp" placeholder="Escribe el nombre la colonia"
                    value="{{ old('settlement', $terminal->settlement ?? '') }}" aria-required="true"
                    name="settlement">
                @if ($errors->has('settlement'))
                    <span id="settlement-error" class="error text-danger" for="input-settlement">
                        {{ $errors->first('settlement') }}
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('location') ? ' has-danger' : '' }} col-sm-5">
                <label for="location">{{ __('Localidad') }}</label>
                <input type="text" class="form-control{{ $errors->has('location') ? ' is-invalid' : '' }}"
                    name="location" id="input-location" value="{{ old('location', $terminal->location ?? '') }}"
                    aria-required="true" aria-describedby="locationHelp" placeholder='Escribe la localidad'
                    aria-required="true">
                @if ($errors->has('location'))
                    <span id="location-error" class="error text-danger" for="input-location">
                        {{ $errors->first('location') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('town') ? ' has-danger' : '' }} col-sm-5">
                <label for="town">{{ __('Ciudad') }}</label>
                <input type="text" class="form-control{{ $errors->has('town') ? ' is-invalid' : '' }}"
                    id="input-town" aria-describedby="townHelp" placeholder="Escribe el nombre la ciudad"
                    value="{{ old('town', $terminal->town ?? '') }}" aria-required="true" name="town">
                @if ($errors->has('town'))
                    <span id="town-error" class="error text-danger" for="input-town">
                        {{ $errors->first('town') }}
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }} col-sm-5">
                <label for="state">{{ __('Estado') }}</label>
                <input type="text" class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}" name="state"
                    id="input-state" value="{{ old('state', $terminal->state ?? '') }}" aria-required="true"
                    aria-describedby="stateHelp" placeholder='Escribe el estado' aria-required="true">
                @if ($errors->has('state'))
                    <span id="state-error" class="error text-danger" for="input-state">
                        {{ $errors->first('state') }}
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="card-footer ml-auto mr-auto">
        <button type="submit" class="btn btn-primary">{{ $button ?? __('Registrar') }}</button>
    </div>
</div>
