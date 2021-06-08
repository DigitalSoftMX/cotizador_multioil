@csrf
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            <a href="{{ route('prices.index') }}" title="Volver a la lista de precios">
                <span class="material-icons">arrow_back_ios</span>
            </a>
            {{ $title ?? __('Agregar precio de competencia') }}
        </h4>
        <p class="card-category">
            {{ __('Aquí puedes administrar los precios de la competencia.') }}</p>
    </div>
    <div class="card-body">
        @include('partials._notification')
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('company_id') ? ' has-danger' : '' }} col-3">
                <select id="input-company_id" name="company_id"
                    class="selectpicker show-menu-arrow {{ $errors->has('company_id') ? ' has-danger' : '' }}"
                    data-style="btn-primary" data-width="100%" data-live-search="true">
                    <option value="">{{ __('Elija una empresa') }}</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" @if (($c = $price->company_id ?? '') == $company->id) selected @endif>{{ $company->name }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('company_id'))
                    <span id="name-company_id" class="error text-danger"
                        for="input-company_id">{{ $errors->first('company_id') }}</span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('terminal_id') ? ' has-danger' : '' }} col-3">
                <select id="input-terminal_id" name="terminal_id"
                    class="selectpicker show-menu-arrow {{ $errors->has('terminal_id') ? ' has-danger' : '' }}"
                    data-style="btn-primary" data-width="100%" data-live-search="true">
                    <option value="">{{ __('Elija una terminal') }}</option>
                    @foreach ($terminals as $terminal)
                        <option value="{{ $terminal->id }}" @if (($t = $price->terminal_id ?? '') == $terminal->id) selected @endif>{{ $terminal->name }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('terminal_id'))
                    <span id="name-terminal_id" class="error text-danger"
                        for="input-terminal_id">{{ $errors->first('terminal_id') }}</span>
                @endif
            </div>
            <div class="col-3">
                <label class="label-control">{{ __('Fecha') }}</label>
                <input class="form-control datetimepicker" id="calendar_first" name="created_at" type="text"
                    value="" /></input>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-3">
                <label for="regular">{{ __('Regular') }}</label>
                <input class="form-control" id="regular" name="regular" placeholder="0" type="number" step="any"
                    value="{{ old('regular', $price->regular ?? '') }}">
                </input>
            </div>
            <div class="col-3">
                <label for="premium">{{ __('Premium') }}</label>
                <input class="form-control" id="premium" name="premium" placeholder="0" type="number" step="any"
                    value="{{ old('premium', $price->premium ?? '') }}">
                </input>
            </div>
            <div class="col-3">
                <label for="disel">{{ __('Diesel') }}</label>
                <input class="form-control" id="diesel" name="diesel" placeholder="0" type="number" step="any"
                    value="{{ old('diesel', $price->diesel ?? '') }}">
                </input>
            </div>
        </div>
        @if (!isset($price))
            <div class="row justify-content-center mt-5">
                <div class="checkbox-radios form-group{{ $errors->has('continue') ? ' has-danger' : '' }} col-3">
                    <label for="bill">{{ __('Registro de precios') }}</label>
                    <div id="radiocontinue"></div>
                    @if ($errors->has('continue'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            {{ $errors->first('continue') }}
                        </span>
                    @endif
                </div>
            </div>
        @endif
        @isset($price)
            <input type="hidden" value="1" name="continue">
        @endisset
    </div>
    <div class="card-footer">
        @if (!isset($price))
            <button id="register" type="submit" class="btn btn-primary">{{ __('Registrar') }}
        @endif
        </button>
        <button id="update" type="submit" class="btn btn-primary">{{ __('Actualizar') }}</button>
    </div>
</div>
