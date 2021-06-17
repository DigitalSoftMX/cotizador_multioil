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
            <div class="form-group{{ $errors->has('pemex') ? ' has-danger' : '' }} col-3 checkbox-radios">
                <label class="label-control" for="pemex">{{ __('Activar el precio para Pemex') }}</label>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="1" name="pemex" id="pemexid">
                        {{ 'Pemex' }}
                        <span class="form-check-sign">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
                @if ($errors->has('pemex'))
                    <span id="pemex-error" class="error text-danger" for="input-pemex">
                        {{ $errors->first('pemex') }}
                    </span>
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
        <div class="row justify-content-center mt-5">
            <div class="checkbox-radios form-group{{ $errors->has('continue') ? ' has-danger' : '' }} col-3">
                <label for="bill">{{ __('Registro de precios') }}</label>
                <div>
                    <div class="form-check-radio">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="continue" value="1">
                            {{ __('Registrar e ir al listado de precios') }}
                        </label>
                    </div>
                    <div class="form-check-radio">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="continue" value="0">
                            {{ __('Registrar y volver') }}
                        </label>
                    </div>
                </div>
                @if ($errors->has('continue'))
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        {{ $errors->first('continue') }}
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="card-footer justify-content-center">
        <button id="register" type="submit" class="btn btn-primary">{{ $btn ?? __('Registrar') }}
        </button>
    </div>
</div>
