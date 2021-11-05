@extends('layouts.app', ['activePage' => 'Pedido Semanal', 'titlePage' => __('Solicitud de pedidos semanales')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="container-fluid mt-3">
                <div class="row">
                    @include('partials.notification')
                    <div class="card card-nav-tabs">
                        <div class="card-header card-header-primary">
                            <div class="row">
                                <div class="col mt-3">{{ __('Solcitud De Pedido Semanal') }}</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="pedidoSemanal" action="{{ route('pedidos.store') }}" method="post"
                                name="calculadora">
                                @csrf
                                <div class="row">
                                    <div class="form-group{{ $errors->has('terminal_id') ? ' has-danger' : '' }} col">
                                        <select id="input-terminal_id" name="terminal_id"
                                            class="selectpicker show-menu-arrow {{ $errors->has('terminal_id') ? ' has-danger' : '' }}"
                                            data-style="btn-primary" data-width="100%" data-live-search="true">
                                            <option selected disabled>{{ __('Elija una terminal') }}</option>
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
                                    @if (auth()->user()->roles->first()->id == 1)
                                        <div class="form-group{{ $errors->has('company_id') ? ' has-danger' : '' }} col">
                                            <select id="input-company_id" name="company_id"
                                                class="selectpicker show-menu-arrow {{ $errors->has('company_id') ? ' has-danger' : '' }}"
                                                data-style="btn-primary" data-width="100%" data-live-search="true">
                                                <option value="">{{ __('Empresa') }}</option>
                                            </select>
                                            @if ($errors->has('company_id'))
                                                <span id="name-company_id" class="error text-danger"
                                                    for="input-company_id">{{ $errors->first('company_id') }}</span>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="col">
                                        <label class="alineacion">{{ __('¿Cuenta con transporte?') }}</label></br>
                                        <div class="form-check-inline alineacion">
                                            <label class="form-check-label" for="radio1">
                                                <input type="radio" class="form-check-input" id="nfleteNo" name="nflete"
                                                    value="No" checked onchange="checkShipper(true)">SI
                                            </label>
                                        </div>
                                        <div class="form-check-inline alineacion">
                                            <label class="form-check-label" for="radio2">
                                                <input type="radio" class="form-check-input" id="nfleteSi" name="nflete"
                                                    value="Si" onchange="checkShipper(false)">NO
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label>{{ __('¿Necesita un seguro?') }}</label><br>
                                        <div class="form-check-inline">
                                            <label class="form-check-label" for="radio3">
                                                <input type="radio" class="form-check-input" id="nseguroSi" name="nseguro"
                                                    value="Si" checked>SI
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label" for="radio4">
                                                <input type="radio" class="form-check-input" id="nseguroNo" name="nseguro"
                                                    value="No">NO
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="card" style="width:230px">
                                            <div class="card-body">
                                                <h5 class="newstyle2">Lunes:
                                                    <input class=form-control name="monday" type="text"
                                                        class="newstyle7" id="monday" style="width:150px"> </input>
                                                </h5>
                                                <div id="lunes">
                                                    @include('Pedidos.input',[$day='L'])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card" style="width:230px">
                                            <div class="card-body">
                                                <h5 class="newstyle2">Martes:
                                                    <input class=form-control name="tuesday" type="text"
                                                        class="newstyle7" id="tuesday" style="width:150px"> </input>
                                                </h5>
                                                <div id="martes">
                                                    @include('Pedidos.input',[$day='Ma'])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card" style="width:230px">
                                            <div class="card-body">
                                                <h5 class="newstyle2">Miércoles:
                                                    <input class=form-control name="wednesday" type="text"
                                                        class="newstyle7" id="wednesday" style="width:150px"> </input>
                                                </h5>
                                                <div id="miercoles">
                                                    @include('Pedidos.input',[$day='Mi'])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="card" style="width:230px">
                                            <div class="card-body">
                                                <h5 class="newstyle2">Jueves:
                                                    <input class=form-control name="thursday" type="text"
                                                        class="newstyle7" id="thursday" style="width:150px"> </input>
                                                </h5>
                                                <div id="jueves">
                                                    @include('Pedidos.input',[$day='J'])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card" style="width:230px">
                                            <div class="card-body">
                                                <h5 class="newstyle2">Viernes:
                                                    <input class=form-control name="friday" type="text"
                                                        class="newstyle7" id="friday" style="width:150px"> </input>
                                                </h5>
                                                <div id="viernes">
                                                    @include('Pedidos.input',[$day='V'])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card borders" style="width:230px">
                                            <div class="card-body borders">
                                                <h5 class="newstyle2">Sábado:
                                                    <input class=form-control name="saturday" type="text"
                                                        class="newstyle7" id="saturday" style="width:150px"> </input>
                                                </h5>
                                                <div id="sabado">
                                                    @include('Pedidos.input',[$day='S'])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="newstyle8">Total semanal de litros por producto</h5>
                                <div class="row " id="content">
                                    <label class="col-sm-2 col-form-label">Regular </label>
                                    <div class="form-group bmd-form-group">
                                        <input class="form-control" name="totalR" id="totalR" type="number"
                                            placeholder="Total de Litros." readonly>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Premium </label>
                                    <div class="form-group bmd-form-group">
                                        <input class="form-control" name="totalP" id="totalP" type="number"
                                            placeholder="Total de litros." readonly>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Diésel </label>
                                    <div class="form-group bmd-form-group">
                                        <input class="form-control" name="totalD" id="totalD" type="number"
                                            placeholder="Total de litros." readonly>
                                    </div>
                                </div>
                                <h5 class="newstyle9">Total de Litros </h5>
                                <div class="form-group bmd-form-group">
                                    <input class="form-control" name="grantotal" id="grantotal" type="number"
                                        placeholder="Total de litros." readonly>
                                </div>
                                <div class="card-footer justify-content-center">
                                    <button id="buttonPedidoSemanal"
                                        onclick="disabledButton('buttonPedidoSemanal','pedidoSemanal')" type="button"
                                        class="btn btn-primary">{{ __('Realizar Pedido') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        let company_client = "{{ $company->id ?? '' }}";
        let company = document.getElementById('input-company_id').value;
        let companies = [];
        let date = new Date();
        let actualOrder = `${date.getMonth() + 1}-${date.getDate() + 1}-${date.getFullYear()}`;
        let dayofweek = `${date.getDay()}`;
        if (dayofweek <= 3) {
            init_calendar('calendar_first', moment().startOf('isoWeek').add(1, 'week'), moment().startOf('isoWeek').add(
                1,
                'week'));

            init_calendar('monday', moment().startOf('isoWeek').add(1, 'week'), moment().startOf('isoWeek').add(1,
                'week'));
            init_calendar('tuesday', moment().day(1 + 1).add(1, 'week'), moment().day(1 + 1).add(1, 'week'));
            init_calendar('wednesday', moment().day(1 + 2).add(1, 'week'), moment().day(1 + 2).add(1, 'week'));
            init_calendar('thursday', moment().day(1 + 3).add(1, 'week'), moment().day(1 + 3).add(1, 'week'));
            init_calendar('friday', moment().day(1 + 4).add(1, 'week'), moment().day(1 + 4).add(1, 'week'));
            init_calendar('saturday', moment().day(1 + 5).add(1, 'week'), moment().day(1 + 5).add(1, 'week'));

        } else {
            init_calendar('calendar_first', moment().startOf('isoWeek').add(2, 'week'), moment().day(1 + 5).add(2,
                'week'));
            init_calendar('monday', moment().startOf('isoWeek').add(2, 'week'), moment().startOf('isoWeek').add(2,
                'week'));
            init_calendar('tuesday', moment().day(1 + 1).add(2, 'week'), moment().day(1 + 1).add(2, 'week'));
            init_calendar('wednesday', moment().day(1 + 2).add(2, 'week'), moment().day(1 + 2).add(2, 'week'));
            init_calendar('thursday', moment().day(1 + 3).add(2, 'week'), moment().day(1 + 3).add(2, 'week'));
            init_calendar('friday', moment().day(1 + 4).add(2, 'week'), moment().day(1 + 4).add(2, 'week'));
            init_calendar('saturday', moment().day(1 + 5).add(2, 'week'), moment().day(1 + 5).add(2, 'week'));
        }
        // calculo de precio total pedido
        $(document).on("keyup", "#liters_r", function() {
            let litersR = document.getElementById('liters_r').value;
            let priceR = document.getElementById('price_r').value;
            priceR != '' ? document.getElementById('total_r').value = litersR * priceR : '';
        });
        $(document).on("keyup", "#liters_p", function() {
            let litersR = document.getElementById('liters_p').value;
            let priceR = document.getElementById('price_p').value;
            priceR != '' ? document.getElementById('total_p').value = litersR * priceR : '';
        });
        $(document).on("keyup", "#liters_d", function() {
            let litersR = document.getElementById('liters_d').value;
            let priceR = document.getElementById('price_d').value;
            priceR != '' ? document.getElementById('total_d').value = litersR * priceR : '';
        });
        // select de terminales
        $(".selectpicker").change(function() {
            let terminal = document.getElementById('input-terminal_id').value;
        });
        $('#input-terminal_id').change(function() {
            if (company_client == '') {
                let terminal = document.getElementById('input-terminal_id').value;
                getTerminals(terminal);
            }
        });
        $('#input-company_id').change(function() {
            company = document.getElementById('input-company_id').value;
            let selected = companies.companies.find(c => c.id === parseInt(company));
            if (selected.shipper) {
                document.getElementById('nfleteSi').checked = false;
                document.getElementById('nfleteNo').checked = true;
                document.getElementById('nseguroSi').checked = false;
                document.getElementById('nseguroNo').checked = true;
                optionInput('inputs', 'lunes', 'L');
                optionInput('inputs', 'martes', 'Ma');
                optionInput('inputs', 'miercoles', 'Mi');
                optionInput('inputs', 'jueves', 'J');
                optionInput('inputs', 'viernes', 'V');
                optionInput('inputs', 'sabado', 'S');

            } else {
                document.getElementById('nfleteSi').checked = true;
                document.getElementById('nfleteNo').checked = false;
                document.getElementById('nseguroSi').checked = true;
                document.getElementById('nseguroNo').checked = false;
                optionInput('options', 'lunes', 'L');
                optionInput('options', 'martes', 'Ma');
                optionInput('options', 'miercoles', 'Mi');
                optionInput('options', 'jueves', 'J');
                optionInput('options', 'viernes', 'V');
                optionInput('options', 'sabado', 'S');
            }
        });

        function checkShipper(checked) {
            if (checked) {
                document.getElementById('nfleteSi').checked = false;
                document.getElementById('nfleteNo').checked = true;
                document.getElementById('nseguroSi').checked = true;
                document.getElementById('nseguroNo').checked = false;
                optionInput('inputs', 'lunes', 'L');
                optionInput('inputs', 'martes', 'Ma');
                optionInput('inputs', 'miercoles', 'Mi');
                optionInput('inputs', 'jueves', 'J');
                optionInput('inputs', 'viernes', 'V');
                optionInput('inputs', 'sabado', 'S');
            } else {
                document.getElementById('nfleteSi').checked = true;
                document.getElementById('nfleteNo').checked = false;
                document.getElementById('nseguroSi').checked = false;
                document.getElementById('nseguroNo').checked = true;
                optionInput('options', 'lunes', 'L');
                optionInput('options', 'martes', 'Ma');
                optionInput('options', 'miercoles', 'Mi');
                optionInput('options', 'jueves', 'J');
                optionInput('options', 'viernes', 'V');
                optionInput('options', 'sabado', 'S');
            }
        }

        // funcion para listar las empresas correspondientes a la terminal
        async function getTerminals(terminal_id) {
            try {
                const resp = await fetch('{{ url('') }}/getcompanies/' + terminal_id);
                companies = await resp.json();
                $('#input-company_id').children('option').remove();
                $('#input-company_id').append( /* html */ `<option selected disabled>Elija una empresa</option>`);
                companies.companies.forEach(company => {
                    $('#input-company_id').append(`<option value="${company.id}">${company.name}</option>`);
                });
                $('#input-company_id').selectpicker('refresh');
            } catch (error) {
                console.log(error)
            }
        }
        // Cambio de input por option y viceversa
        function optionInput(type, day, d) {
            let name = document.getElementById(day);
            if (type == 'inputs') {
                name.innerHTML = /* html */ `@include('Pedidos.input',[$day='${d}'])`;
            }
            if (type == 'options') {
                name.innerHTML = /* html */ `@include('Pedidos.optionsLiters',[$day='${d}'])`;
                $(`#input-regular${d}`).selectpicker('refresh');
                $(`#input-premium${d}`).selectpicker('refresh');
                $(`#input-diesel${d}`).selectpicker('refresh');
            }
        }
    </script>
@endpush
