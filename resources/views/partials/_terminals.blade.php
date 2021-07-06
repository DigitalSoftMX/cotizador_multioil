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
            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }} col-sm-5">
                <label for="name">{{ __('Nombre') }}</label>
                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="input-name"
                    aria-describedby="nameHelp" placeholder="Escribe el nombre de la terminal"
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
            <div class="form-group{{ $errors->has('n_outsice') ? ' has-danger' : '' }} col-sm-5">
                <label for="n_outsice">{{ __('Número exterior') }}</label>
                <input type="text" class="form-control{{ $errors->has('n_outsice') ? ' is-invalid' : '' }}"
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
        <hr>
        <div class="row justify-content-center">
            <h4>{{ __('Geolocalización de la terminal') }}</h4>
        </div>
        <hr>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('latitude') ? ' has-danger' : '' }} col-sm-5">
                <label for="latitude">{{ __('Latitud') }}</label>
                <input type="text" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}"
                    id="input-latitude" aria-describedby="latitudeHelp"
                    placeholder="Escribe la latitud de la terminal"
                    value="{{ old('latitude', $terminal->latitude ?? '') }}" aria-required="true"
                    name="latitude">
                @if ($errors->has('latitude'))
                    <span id="latitude-error" class="error text-danger" for="input-latitude">
                        {{ $errors->first('latitude') }}
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('longitude') ? ' has-danger' : '' }} col-sm-5">
                <label for="longitude">{{ __('longitud') }}</label>
                <input type="text" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" name="longitude"
                    id="input-longitude" value="{{ old('longitude', $terminal->longitude ?? '') }}" aria-required="true"
                    aria-describedby="longitudeHelp" placeholder='Escribe la longitud de la terminal' aria-required="true">
                @if ($errors->has('longitude'))
                    <span id="longitude-error" class="error text-danger" for="input-longitude">
                        {{ $errors->first('longitude') }}
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="card-footer ml-auto mr-auto">
        <button type="submit" class="btn btn-primary">{{ $button ?? __('Registrar') }}</button>
    </div>
</div>
