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
            @if (!isset($price))
                <div class="form-group{{ $errors->has('pemex') ? ' has-danger' : '' }} col-3 checkbox-radios">
                    <label class="label-control" for="pemex">{{ __('Activar el precio para Pemex') }}</label>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" value="1" name="pemex" id="pemexid" @if (($p = $price->company_id ?? '') == 15) checked @endif>
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
            @else
                <div class="form-group{{ $errors->has('company_id') ? ' has-danger' : '' }} col-3">
                    <select id="input-company_id" name="company_id"
                        class="selectpicker show-menu-arrow {{ $errors->has('company_id') ? ' has-danger' : '' }}"
                        data-style="btn-primary" data-width="100%" data-live-search="true">
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" @if (($e = $price->company_id ?? '') == $company->id) selected @endif>{{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('company_id'))
                        <span id="name-company_id" class="error text-danger"
                            for="input-company_id">{{ $errors->first('company_id') }}</span>
                    @endif
                </div>
            @endif
            <div class="form-group{{ $errors->has('terminal_id') ? ' has-danger' : '' }} col-3">
                <select id="input-terminal_id" name="terminal_id"
                    class="selectpicker show-menu-arrow {{ $errors->has('terminal_id') ? ' has-danger' : '' }}"
                    data-style="btn-primary" data-width="100%" data-live-search="true">
                    <option value="0">{{ __('Elija una terminal') }}</option>
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
                <div id="radiocontinue">
                    <div class="form-check-radio">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="continue" value="1" checked>
                            {{ $price ?? null != null ? 'Actualizar' : 'Registrar' }}{{ 'e ir al listado de precios' }}
                        </label>
                    </div>
                    <div class="form-check-radio">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="continue" value="0">
                            {{ $price ?? null != null ? 'Actualizar' : 'Registrar' }} {{ 'y volver' }}
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
    <div class="card-footer {{ $price ?? null != null ? 'justify-content-center' : '' }}">
        @if (!isset($price))
            <button id="register" type="submit" class="btn btn-primary">{{ __('Registrar') }}
            </button>
        @endif
        <button id="update" type="submit" class="btn btn-primary">{{ __('Actualizar') }}
        </button>
    </div>
</div>
@push('js')
    <script>
        let id = "{{ $price->id ?? '' }}"
        let next = false;
        let date = new Date();
        let register = document.getElementById('register');
        let update = document.getElementById('update');
        let company_id = '';
        $(document).ready(function() {
            init_calendar('calendar_first', `01-01-${date.getFullYear()}`, `12-31-${date.getFullYear()}`);
            if (id == '') {
                let month = date.getMonth() + 1;
                let day = date.getDate();
                update.classList.remove('btn-primary');
                update.disabled = true;
                messageRadio('Registrar');
                $('#calendar_first').val(`${date.getFullYear()}-${month<10?'0'+month:month}-${day<10?'0'+day:day}`);
            } else {
                $('#calendar_first').val("{{ isset($price) ? $price->created_at->format('Y-m-d') : '' }}");
            }
        });
        update.onclick = () => {
            if (next) {
                if (confirm(
                        'Atención. Ya existen precios registrados. ¿Esta seguro de actualizarlo con los nuevos datos?'))
                    return true;
                return false
            }
        }
        $('#pemexid').change(function() {
            value();
        });

        $(".selectpicker").change(function() {
            let terminal_id = document.getElementById('input-terminal_id').value;
            if (id != '') {
                company_id = document.getElementById('input-company_id').value;
            }
        });

        $('#input-terminal_id').change(function() {
            value();
        });
        $('#input-company_id').change(function() {
            value();
        });
        $("#calendar_first").blur(function() {
            value();
        });
        // método para los valores de peme, terminal y fecha
        function value() {
            let pemexcheck = 0;
            if (id != '') {
                company_id = document.getElementById('input-company_id').value;
                pemexcheck = company_id == '15' ? 1 : 0;
            } else {
                pemexcheck = $("#pemexid").is(":checked") ? 1 : 0;
            }
            let terminal = $('#input-terminal_id').val();
            let fecha = $('#calendar_first').val();
            getPrice(pemexcheck, terminal, fecha);
        }
        // pregunta si existe precios con pemex, terminal y fecha
        async function getPrice(pemex, terminal, date) {
            try {
                const resp = await fetch(`{{ url('') }}/getprice/${pemex}/${terminal}/${date}`);
                const data = await resp.json();
                next = data.price;
                if (data.price) {
                    showNotification();
                    if (id == '') {
                        messageRadio('Actualizar')
                        update.classList.add('btn-primary');
                        update.disabled = false;
                        register.classList.remove('btn-primary');
                        register.disabled = true;
                    }
                } else {
                    if (id == '') {
                        register.classList.add('btn-primary');
                        register.disabled = false;
                        update.classList.remove('btn-primary');
                        update.disabled = true;
                        messageRadio('Registrar')
                    }
                }
            } catch (error) {
                console.log(error)
            }
        }
        // Metodo para notificacion
        function showNotification() {
            $.notify({
                icon: "warning",
                message: "<b>Atención</b> ya existen precios registrados con la misma fecha."

            }, {
                type: 'danger',
                timer: 4000,
                placement: {
                    from: 'top',
                    align: 'center'
                }
            });
        }
        // Metodo para cambiar mensaje del los radiobutton
        function messageRadio(message) {
            let radio = document.getElementById('radiocontinue');
            radio.innerHTML = '';
            radio.innerHTML = /* html */ `
            <div class="form-check-radio">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="continue" value="1" checked>
                        ${ message } e ir al listado de precios
                </label>
            </div>
            <div class="form-check-radio">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="continue" value="0">
                    ${ message } y volver
                </label>
            </div>`
        }
    </script>
@endpush