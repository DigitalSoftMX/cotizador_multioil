@extends('layouts.app', ['activePage' => 'Crea un pedido', 'titlePage' => __('Solicitud de pedidos')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form id="form" method="post" action="{{ route('orders.store') }}" autocomplete="off"
                        class="form-horizontal">
                        @method('post')
                        @csrf
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">{{ __('Solicitud de pedidos') }}</h4>
                                <p class="card-category"> {{ __('Aquí puedes cotizar el pedido diario de gasolina.') }}
                                </p>
                            </div>
                            <div class="card-body">
                                @include('partials._notification')
                                <div class="row">
                                    <div class="col-12 text-right">
                                        <a href="{{ route('validations.index') }}"
                                            class="btn btn-sm btn-success">{{ __('Ir a la lista de pedidos') }}</a>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="form-group{{ $errors->has('terminal_id') ? ' has-danger' : '' }} col-3">
                                        <select id="input-terminal_id" name="terminal_id"
                                            class="selectpicker show-menu-arrow {{ $errors->has('terminal_id') ? ' has-danger' : '' }}"
                                            data-style="btn-primary" data-width="100%" data-live-search="true">
                                            <option value="">{{ __('Elija una terminal') }}</option>
                                            @foreach ($terminals as $terminal)
                                                <option id="t_{{ $terminal->id }}" value="{{ $terminal->id }}">
                                                    {{ $terminal->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('terminal_id'))
                                            <span id="name-terminal_id" class="error text-danger"
                                                for="input-terminal_id">{{ $errors->first('terminal_id') }}</span>
                                        @endif
                                    </div>
                                    @if (auth()->user()->roles()->first()->id == 1)
                                        <div
                                            class="form-group{{ $errors->has('company_id') ? ' has-danger' : '' }} col-3">
                                            <select id="input-company_id" name="company_id"
                                                class="selectpicker show-menu-arrow {{ $errors->has('company_id') ? ' has-danger' : '' }}"
                                                data-style="btn-primary" data-width="100%" data-live-search="true">
                                                <option value="">Elija un empresa</option>
                                            </select>
                                            @if ($errors->has('company_id'))
                                                <span id="name-company_id" class="error text-danger"
                                                    for="input-company_id">{{ $errors->first('company_id') }}</span>
                                            @endif
                                        </div>
                                    @endif
                                    @if (auth()->user()->roles()->first()->id == 2)
                                        <input type="hidden" name="company_id" value="{{$company->id}}">
                                    @endif
                                    <div class="col-3">
                                        <label class="label-control">{{ __('Fecha de entrega') }}</label>
                                        <input class="form-control datetimepicker" id="calendar_first" name="date"
                                            type="text" value="" /></input>
                                    </div>
                                </div>
                                <div class="row justify-content-center mt-5">
                                    <div class="table-responsive col-lg-6 col-md-9 col-sm-12">
                                        <table id="datatables" class="table table-bordered">
                                            <thead class="text-primary">
                                                <th><strong>{{ __('Producto') }}</strong></th>
                                                <th><strong>{{ __('Costo') }}</strong></th>
                                                <th><strong>{{ __('Litros') }}</strong></th>
                                                <th><strong>{{ __('Total') }}</strong></th>
                                            </thead>
                                            <tbody>
                                                @include('partials._tableprices',[$product='Regular',$p='r'])
                                                @include('partials._tableprices',[$product='Premium',$p='p'])
                                                @include('partials._tableprices',[$product='Diesel',$p='d'])
                                                <tr>
                                                    <td colspan="3">
                                                        <h4 class="text-right font-weight-bold">{{ __('Monto Total') }}
                                                        </h4>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" id="total_price" name="total_price"
                                                            type="text" value="" step="any" placeholder="0.00" readonly
                                                            required />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div
                                        class="checkbox-radios form-group{{ $errors->has('freight') ? ' has-danger' : '' }} col-3">
                                        <label for="freight">{{ __('¿Requieres flete?') }}</label>
                                        <div class="form-check-radio">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="freight" value="1">
                                                Sí
                                            </label>
                                        </div>
                                        <div class="form-check-radio">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="freight" value="0">
                                                No
                                            </label>
                                        </div>
                                        @if ($errors->has('freight'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                {{ $errors->first('freight') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div
                                        class="checkbox-radios form-group{{ $errors->has('secure') ? ' has-danger' : '' }} col-3">
                                        <label for="secure">{{ __('¿Deseas asegurar tu flete?') }}</label>
                                        <div class="form-check-radio">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="secure" value="1">
                                                Sí
                                            </label>
                                        </div>
                                        <div class="form-check-radio">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="secure" value="0">
                                                No
                                            </label>
                                        </div>
                                        @if ($errors->has('secure'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                {{ $errors->first('secure') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-5">
                                        <button id="orderbutton" type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#orderModal" onclick="ticket()" disabled>
                                            {{ __('Solicitar pedido') }}
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="orderModal" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title font-weight-bold">
                                                            {{ __('Solicitud de pedido') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div id="ticket"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button id="btnCancel" type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">{{ __('Cancelar pedido') }}</button>
                                                        <button type="submit" id="btnSubmit"
                                                            class="btn btn-primary">{{ __('Confirmar pedido') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        let date = new Date();
        let actualOrder = `${date.getMonth() + 1}-${date.getDate() + 1}-${date.getFullYear()}`;
        let total_regular = 0;
        let total_premium = 0;
        let total_diesel = 0;
        let total_price = 0;
        let freight = 0;
        let secure = 0;
        let company_client="{{ $company->id ?? ''}}"
        init_calendar('calendar_first', actualOrder, actualOrder);
        // calculo de precio total pedido
        $(document).on("keyup", "#liters_r", function() {
            totalPrice('r')
        });
        $(document).on("keyup", "#liters_p", function() {
            totalPrice('p')
        });
        $(document).on("keyup", "#liters_d", function() {
            totalPrice('d')
        });
        // select de terminales
        $(".selectpicker").change(function() {
            let terminal = document.getElementById('input-terminal_id').value;
            if(company_client!=''){
                let company = company_client;
                getPrices(company, terminal);
                document.getElementById('orderbutton').disabled = false;
            }else{
                let company = document.getElementById('input-company_id').value;
            }
        });
        $('#input-terminal_id').change(function() {
            if(company_client==''){
                let terminal = document.getElementById('input-terminal_id').value;
                getTerminals(terminal);
            }
        });
        // select de empresas o clientes
        $('#input-company_id').change(function() {
            let company = document.getElementById('input-company_id').value;
            let terminal = document.getElementById('input-terminal_id').value;
            if (company != '') {
                getPrices(company, terminal);
                document.getElementById('orderbutton').disabled = false;
            }
        });
        // valor del freight
        $("input[name=freight]").click(function() {
            freight = $('input:radio[name=freight]:checked').val();
        });
        $("input[name=secure]").click(function() {
            secure = $('input:radio[name=secure]:checked').val();
        });
        // desactiva el boton de formulario
        $("#form").submit(function(e) {
            $("#btnSubmit").attr("disabled", true);
            $("#btnCancel").attr("disabled", true);
        });
        // funcion para listar las empresas correspondientes a la terminal
        async function getTerminals(terminal_id) {
            try {
                const resp = await fetch('{{ url('') }}/getcompanies/' + terminal_id);
                const companies = await resp.json();
                $('#input-company_id').children('option').remove();
                $('#input-company_id').append(`<option value="">Elija un empresa</option>`);
                companies.companies.forEach(company => {
                    $('#input-company_id').append(
                        `<option id="c_${company.id}" value="${company.id}">${company.name}</option>`);
                });
                $('#input-company_id').selectpicker('refresh');
            } catch (error) {
                console.log(error)
            }
        }
        // funcion para obtener los ultimos precios de la empresa y terminal
        async function getPrices(company_id, terminal_id) {
            try {
                const resp = await fetch('{{ url('') }}/getlastprice/' + `${company_id}/${terminal_id}`);
                const prices = await resp.json();
                console.log(prices);
                document.getElementById('price_r').value =
                    (prices.prices.regular + (prices.fees != null ? prices.fees.regular_fit : 0)).toFixed(2);
                document.getElementById('price_p').value =
                    (prices.prices.premium + (prices.fees != null ? prices.fees.premium_fit : 0)).toFixed(2);
                document.getElementById('price_d').value =
                    (prices.prices.diesel + (prices.fees != null ? prices.fees.diesel_fit : 0)).toFixed(2);
                totalPrice('r');
                totalPrice('p');
                totalPrice('d');
            } catch (error) {
                console.log(error)
            }
        }
        // calculo total de cada producto por pedido
        function totalPrice(product) {
            let liters = document.getElementById('liters_' + product).value;
            let price = document.getElementById('price_' + product).value;
            price != '' ? document.getElementById('total_' + product).value =
                '$ ' + (liters * price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') : '';
            switch (product) {
                case 'r':
                    total_regular = liters * price;
                    total_price = total_regular + total_premium + total_diesel;
                    price != '' ? document.getElementById('total_price').value =
                        '$ ' + total_price.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') : '';
                    break;
                case 'p':
                    total_premium = liters * price;
                    total_price = total_regular + total_premium + total_diesel;
                    price != '' ? document.getElementById('total_price').value =
                        '$ ' + total_price.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') : '';
                    break;
                case 'd':
                    total_diesel = liters * price;
                    total_price = total_regular + total_premium + total_diesel;
                    price != '' ? document.getElementById('total_price').value =
                        '$ ' + total_price.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') : '';
                    break;
            }
        }

        function ticket() {
            try {
                let terminal = document.getElementById('input-terminal_id').value;
                let company = company_client==''? document.getElementById('input-company_id').value:company_client;
                let litersR = document.getElementById('liters_r').value;
                let litersP = document.getElementById('liters_p').value;
                let litersD = document.getElementById('liters_d').value;
                let priceR = document.getElementById('price_r').value;
                let priceP = document.getElementById('price_p').value;
                let priceD = document.getElementById('price_d').value;
                let total_r = document.getElementById('total_r').value;
                let total_p = document.getElementById('total_p').value;
                let total_d = document.getElementById('total_d').value;
                let total = document.getElementById('total_price').value;
                let nameTerminal = document.getElementById(`t_${terminal}`).innerText;
                let nameCompany = company_client==''? document.getElementById(`c_${company}`).innerText:"{{$company->name??''}}";
                let ticket = document.getElementById('ticket').innerHTML = /* html */
                    `<strong class="font-weight-bold">Fecha de entrega: </strong>${actualOrder}<br>
                    <strong class="font-weight-bold">Terminal: </strong>${nameTerminal}<br>
                    <strong class="font-weight-bold">Empresa: </strong>${nameCompany}
                    <table style="width:100%">
                        <tr>
                            <th>Concepto</th>
                            <th>Litros</th>
                            <th>Precio x Litro</th>
                            <th>Importe</th>
                        </tr>
                        <tr>
                            <td>Regular</td>
                            <td>${litersR!=''?litersR:'0'} LTS</td>
                            <td>$ ${litersR!=''?priceR:'0'}</td>
                            <td>${total_r}</td>
                        </tr>

                        <tr>
                            <td>Premium</td>
                            <td>${litersP!=''?litersP:'0'} LTS</td>
                            <td>$ ${litersP!=''?priceP:'0'}</td>
                            <td>${total_p}</td>
                        </tr>

                        <tr>
                            <td>Diesel</td>
                            <td>${litersD!=''?litersD:'0'} LTS</td>
                            <td>$ ${litersD!=''?priceD:'0'}</td>
                            <td>${total_d}</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right">Total: </th>
                            <th>${total}</th>
                        </tr>
                        </table>
                    <strong class="font-weight-bold"> ¿Requiere flete? : </strong>${freight==0?'No':'Si'}<br>
                    <strong class="font-weight-bold"> ¿Seguro de flete? : </strong>${secure==0?'No':'Si'}<br>`;
            } catch (error) {
                console.log(error)
                alert('Completa todos los campos para realizar un pedido');
            }
        }

    </script>
@endpush