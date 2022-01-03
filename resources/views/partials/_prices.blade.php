@csrf
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            <a href="{{ route('prices.index') }}" title="Volver a la lista de precios">
                <span class="material-icons">arrow_back_ios</span>
            </a>
            {{ $title ?? __('Agregar precio de competencia') }}
        </h4>
    </div>
    <div class="card-body">
        @include('partials._notification')
        <div class="row justify-content-center">
            <div class="col-md-9 col-sm-12 text-center">
                <h4>{{ __('Captura de precios') }}</h4>
                <div class="row justify-content-center">
                    <div class="form-group{{ $errors->has('base_id') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                        <select id="input-base_id" name="base_id"
                            class="selectpicker show-menu-arrow {{ $errors->has('base_id') ? ' has-danger' : '' }}"
                            data-style="btn-primary" data-width="100%" data-live-search="true">
                            <option value="">{{ __('Precio base') }}</option>
                            @foreach ($bases as $base)
                                <option value="{{ $base->id }}" @if (($b = $price->fee->base_id ?? '') == $base->id) selected @endif>
                                    {{ $base->name }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('base_id'))
                            <span id="name-base_id" class="error text-danger"
                                for="input-base_id">{{ $errors->first('base_id') }}</span>
                        @endif
                    </div>
                    <div id="terminales"
                        class="form-group{{ $errors->has('terminal_id') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                        <select id="input-terminal_id" name="terminal_id"
                            class="selectpicker show-menu-arrow {{ $errors->has('terminal_id') ? ' has-danger' : '' }}"
                            data-style="btn-primary" data-width="100%" data-live-search="true">
                            <option value="">{{ __('Elija la terminal') }}</option>
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
                    <div class="col-md-4 col-sm-12">
                        <label class="label-control">{{ __('Fecha') }}</label>
                        <input class="form-control datetimepicker" id="calendar" name="created_at" type="text"
                            value="" /></input>
                        @if ($errors->has('created_at'))
                            <span id="name-created_at" class="error text-danger"
                                for="input-created_at">{{ $errors->first('created_at') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-4 col-sm-12">
                        <label for="regular">{{ __('Regular') }}</label>
                        <input class="form-control" id="regular" name="regular" placeholder="0" type="number"
                            step="any" value="{{ old('regular', $price->regular ?? '') }}" />
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="premium">{{ __('Premium') }}</label>
                        <input class="form-control" id="premium" name="premium" placeholder="0" type="number"
                            step="any" value="{{ old('premium', $price->premium ?? '') }}" />
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="disel">{{ __('Diesel') }}</label>
                        <input class="form-control" id="diesel" name="diesel" placeholder="0" type="number" step="any"
                            value="{{ old('diesel', $price->diesel ?? '') }}" />
                    </div>
                </div>
                <div class="row justify-content-center">
                    @if ($errors->has('prices'))
                        <span class="error text-danger text-center" style="display: block;" role="alert">
                            {{ __('Debe subir al menos un precio de un tipo de gasolina') }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-md-9 col-sm-12 text-center">
                <h4>{{ __('Buscar FEE disponibles') }}</h4>
                <div class="row justify-content-center">
                    <div class="form-group{{ $errors->has('terminal') ? ' has-danger' : '' }} col-md-3 col-sm-12">
                        <select id="input-terminal" name="terminal"
                            class="selectpicker show-menu-arrow {{ $errors->has('terminal') ? ' has-danger' : '' }}"
                            data-style="btn-primary" data-width="100%" data-live-search="true">
                            <option value="0">{{ __('Elija una terminal') }}</option>
                            @foreach ($terminals as $terminal)
                                <option value="{{ $terminal->id }}" @if (($t = $price->fee->terminal_id ?? '') == $terminal->id) selected @endif>
                                    {{ $terminal->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group{{ $errors->has('company') ? ' has-danger' : '' }} col-md-3 col-sm-12">
                        <select id="input-company" name="company"
                            class="selectpicker show-menu-arrow {{ $errors->has('company') ? ' has-danger' : '' }}"
                            data-style="btn-primary" data-width="100%" data-live-search="true">
                            <option value="0">{{ __('Elija una empresa') }}</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}" @if (($c = $price->fee->company_id ?? '') == $company->id) selected @endif>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group{{ $errors->has('base') ? ' has-danger' : '' }} col-md-3 col-sm-12">
                        <select id="input-base" name="base_id"
                            class="selectpicker show-menu-arrow {{ $errors->has('base_id') ? ' has-danger' : '' }}"
                            data-style="btn-primary" data-width="100%" data-live-search="true">
                            <option value="0">{{ __('Precio base') }}</option>
                            @foreach ($bases as $base)
                                <option value="{{ $base->id }}" @if (($b = $price->fee->base_id ?? '') == $base->id) selected @endif>
                                    {{ $base->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-12 text-left">
                        <label class="label-control">{{ __('Fecha') }}</label>
                        <input class="form-control datetimepicker" id="calendar_first" name="date" type="text"
                            value="" />
                    </div>
                </div>
                <div class="material-datatables">
                    <table cellspacing="0" class="table table-striped table-no-bordered table-hover" id="datatables"
                        style="width:100%" width="100%">
                        <thead class="text-primary">
                            <th>{{ __('Empresa') }}</th>
                            <th>{{ __('Terminal') }}</th>
                            <th>{{ __('Precio base') }}</th>
                            <th>{{ __('Regular Fee') }}</th>
                            <th>{{ __('Premium Fee') }}</th>
                            <th>{{ __('Diesel Fee') }}</th>
                            <th>{{ __('Fecha de Alta') }}</th>
                            <th>{{ __('') }}</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    @if ($errors->has('company'))
                        <span id="name-company" class="error text-danger"
                            for="input-company">{{ $errors->first('company') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div
            class="checkbox-radios form-group{{ $errors->has('continue') ? ' has-danger' : '' }} col-md-3 col-sm-12">
            <label for="bill">{{ __('Registro de precios') }}</label>
            <div id="radiocontinue">
                <div class="form-check-radio">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="continue" value="1" checked>
                        {{ 'Registrar e ir al listado de precios' }}
                    </label>
                </div>
                <div class="form-check-radio">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="continue" value="0">
                        {{ 'Registrar y volver' }}
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
    <div class="card-footer justify-content-center">
        @if (!isset($price))
            <div id="companies"></div>
        @endif
        <button id="button" type="submit" class="btn btn-primary">{{ __('Registrar') }}
        </button>
    </div>
</div>
@push('js')
    <script src="{{ asset('js/ventas.js') }}"></script>
    <script>
        let next = false;
        let date = new Date();
        let id = "{{ $price ?? '' }}";
        let idFee = "{{ $price->fee_id ?? '' }}";
        let notification = 0;
        let companies = [];
        let year = '{{ $year }}';
        $(document).ready(function() {
            loadTable('datatables');
            init_calendar('calendar_first', `01-01-${year}`, `12-31-${date.getFullYear()}`);
            init_calendar('calendar', `01-01-${year}`, `12-31-${date.getFullYear()}`);
            if (id != '') {
                $('#calendar').val("{{ isset($price) ? $price->created_at->format('Y-m-d') : '' }}");
                getValues();
            }
        });
        $(".selectpicker").change(function() {});
        // Obteniendo los fee
        $('#input-terminal').change(function() {
            getValues();
        });
        $('#input-company').change(function() {
            getValues();
        });
        $('#input-base').change(function() {
            getValues();
        });
        $("#calendar_first").blur(function() {
            getValues();
        });
        //Verificacion de precios registrados
        $("#calendar").blur(function() {
            getValuesToLookingForAFee();
        });
        button.onclick = () => {
            if (next) {
                if (confirm(
                        'Atención. Puede que algunos precios se actualicen. ¿Desea continuar?'
                    ))
                    return true;
                return false
            }
        }
        // Metodo para obtener los valores antes del fee
        function getValues() {
            let terminal = document.getElementById('input-terminal').value;
            let company = document.getElementById('input-company').value;
            let base = document.getElementById('input-base').value;
            let date = $('#calendar_first').val();
            getFees(terminal, company, base, date != '' ? date : null);
        }
        // Metodo para obtener un posible fee registrado
        function getValuesToLookingForAFee(fee = '') {
            // let fee = '';
            if (id != '') {
                fee = $('input[name="companies"]:checked').val();
            } else {
                if (fee != '') {
                    if (document.getElementById('fee_' + fee).checked) {
                        companies.push(fee);
                    } else {
                        companies = companies.filter(function(item) {
                            return item !== fee
                        })
                    }
                    document.getElementById('companies').innerHTML = '';
                    companies.forEach(id => {
                        document.getElementById('companies').innerHTML += /* html */ `
                    <input type="hidden" name="companies[]" value="${id}">
                    `
                    });
                }
            }
            let date = $('#calendar').val();
            if (date != '' && fee !== undefined) {
                lookingForPrices(date, fee);
            }
        }
        // Obteniendo los fee
        async function getFees(terminal, company, base, date) {
            try {
                const resp = await fetch(`{{ url('') }}/getfee/${terminal}/${company}/${base}/${date}`);
                const data = await resp.json();
                console.log(data);
                destruir_table("datatables");
                $('#datatables').find('tbody').empty();
                data.fees.forEach(fee => {
                    $("#datatables").find('tbody').append( /* html */
                        `<tr>
                            <td>${fee.terminal}</td>
                            <td>${fee.company}</td>
                            <td>${fee.base}</td>
                            <td>${fee.regular_fee}</td>
                            <td>${fee.premium_fee}</td>
                            <td>${fee.diesel_fee}</td>
                            <td>${fee.date}</td>
                            <td>${setHtmlCheckRadio(fee.id)}</td>
                        </tr>`
                    );
                });
                loadTable('datatables');
            } catch (error) {
                console.log(error)
            }
        }
        //Verificación de precio
        async function lookingForPrices(date, fee) {
            try {
                const resp = await fetch('{{ url('') }}/getprice', {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": $('input[name="_token"]').val()
                    },
                    method: "POST",
                    body: JSON.stringify({
                        date: date,
                        fee: fee
                    })
                })
                const data = await resp.json();
                console.log(data);
                if ((data.price || data.date) && notification == 0) {
                    showNotification(
                        "<b>Atención</b> ya existen precios registrados con la misma fecha y/o empresa/terminal.",
                        'danger');
                    notification++;
                    next = true;
                } else {
                    next = false;
                }
            } catch (error) {
                console.log(error);
            }
        }
        // Metodo para notificacion
        function showNotification(message, color) {
            $.notify({
                icon: "warning",
                message: message

            }, {
                type: color,
                timer: 4000,
                placement: {
                    from: 'top',
                    align: 'center'
                }
            });
        }
        // html check o radio button, registro/edicion
        const setHtmlCheckRadio = (fee) => {
            let stringHtml = '';
            if (idFee == fee) {
                stringHtml = /* html */ `
                <input type = "radio"
                value = "${fee}"
                name = "companies" checked onchange="getValuesToLookingForAFee(${fee})">`
            } else {
                if (id != '') {
                    stringHtml = /* html */ `
                        <input type = "radio"
                        value = "${fee}"
                        name = "companies" onchange="getValuesToLookingForAFee(${fee})">`
                } else {
                    stringHtml = /* html */ `
                        <input type = "checkbox" id="fee_${fee}"
                        value = "${fee}"
                        name = "empresas[]" onchange="getValuesToLookingForAFee(${fee})">`
                }
            }
            return stringHtml;
        }
    </script>
@endpush
