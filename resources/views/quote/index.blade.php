@extends('layouts.app', ['activePage' => 'Crea un pedido', 'titlePage' => __('Solicitud de pedidos')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Solicitud de pedidos') }}</h4>
                            <p class="card-category"> {{ __('Aquí puedes cotizar el pedido diario de gasolina.') }}</p>
                        </div>
                        <div class="card-body">
                            @include('partials._notification')
                            <div class="row justify-content-center">
                                <div class="form-group{{ $errors->has('terminal') ? ' has-danger' : '' }} col-3">
                                    <select id="input-terminal" name="terminal"
                                        class="selectpicker show-menu-arrow {{ $errors->has('terminal') ? ' has-danger' : '' }}"
                                        data-style="btn-primary" data-width="100%" data-live-search="true">
                                        <option value="">{{ __('Elija una terminal') }}</option>
                                        @foreach ($terminals as $terminal)
                                            <option value="{{ $terminal->id }}">{{ $terminal->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('terminal'))
                                        <span id="name-terminal" class="error text-danger"
                                            for="input-terminal">{{ $errors->first('terminal') }}</span>
                                    @endif
                                </div>
                                @if (auth()->user()->roles()->first()->id == 1)
                                    <div class="form-group{{ $errors->has('company_id') ? ' has-danger' : '' }} col-3">
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
                                <div class="col-3">
                                    <label class="label-control">{{ __('Fecha de entrega') }}</label>
                                    <input class="form-control datetimepicker" id="calendar_first" name="created_at"
                                        type="text" value="" /></input>
                                </div>
                            </div>
                            <div class="row justify-content-center mt-5">
                                <div class="table-responsive col-6">
                                    <table id="datatables" class="table table-bordered">
                                        <thead class="text-primary">
                                            <th><strong>{{ __('Producto') }}</strong></th>
                                            <th><strong>{{ __('Costo') }}</strong></th>
                                            <th><strong>{{ __('Litros') }}</strong></th>
                                            <th><strong>{{ __('Monto total') }}</strong></th>
                                        </thead>
                                        <tbody>
                                            @include('partials._tableprices',[$product='Regular',$p='r'])
                                            @include('partials._tableprices',[$product='Premium',$p='p'])
                                            @include('partials._tableprices',[$product='Diesel',$p='d'])
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div
                                    class="checkbox-radios form-group{{ $errors->has('continue') ? ' has-danger' : '' }} col-3">
                                    <label for="bill">{{ __('¿Requieres flete?') }}</label>
                                    <div class="form-check-radio">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="continue" value="1">
                                            Sí
                                        </label>
                                    </div>
                                    <div class="form-check-radio">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="continue" value="0">
                                            No
                                        </label>
                                    </div>
                                    @if ($errors->has('continue'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('continue') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        let date = new Date();
        let actualOrder = `${date.getMonth() + 1}-${date.getDate() + 1}-${date.getFullYear()}`;
        init_calendar('calendar_first', actualOrder, actualOrder);
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
            let terminal = document.getElementById('input-terminal').value;
            let company = document.getElementById('input-company_id').value;
        });
        $('#input-terminal').change(function() {
            let terminal = document.getElementById('input-terminal').value;
            getTerminals(terminal);
        });
        // select de empresas o clientes
        $('#input-company_id').change(function() {
            let company = document.getElementById('input-company_id').value;
            let terminal = document.getElementById('input-terminal').value;
            company != '' ? getPrices(company, terminal) : '';
        });
        // funcion para listar las empresas correspondientes a la terminal
        async function getTerminals(terminal_id) {
            try {
                const resp = await fetch('{{ url('') }}/getcompanies/' + terminal_id);
                const companies = await resp.json();
                $('#input-company_id').children('option').remove();
                $('#input-company_id').append( /* html */ `
                            <option value="">Elija un empresa</option>
                        `);
                companies.companies.forEach(company => {
                    $('#input-company_id').append( /* html */ `
                                <option value="${company.id}">${company.name}</option>
                            `);
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
                document.getElementById('price_r').value = prices.prices.regular + prices.fees.regular_fit;
                document.getElementById('price_p').value = prices.prices.premium + prices.fees.premium_fit;
                document.getElementById('price_d').value = prices.prices.diesel + prices.fees.diesel.fit;
            } catch (error) {
                console.log(error)
            }
        }

    </script>
@endpush
