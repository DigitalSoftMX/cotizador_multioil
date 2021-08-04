@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="container-fluid mt-3">
                <div class="row">
                    <div class="card card-nav-tabs">
                        <div class="card-header card-header-primary">
                            <div class="row">
                                <div class="col-9">
                                    <h4 class="card-title ">{{ __('Graficas de competencias') }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @include('partials._notification')
                            @if (auth()->user()->roles->first()->id == 1)
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <a href="{{ route('prices.index') }}"
                                            class="btn btn-sm btn-success">{{ __('Capturar precios') }}</a>
                                    </div>
                                </div>
                            @endif
                            @if (auth()->user()->roles->first()->id == 2)
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <a href="{{ route('getshopping', auth()->user()->company_id) }}"
                                            class="btn btn-sm btn-success">{{ __('Ver mi estado de cuenta') }}</a>
                                    </div>
                                </div>
                            @endif
                            <div class="row justify-content-md-start">
                                <div class="form-group{{ $errors->has('terminal_id') ? ' has-danger' : '' }} col-sm-3">
                                    <select id="input-terminal_id" name="terminal_id"
                                        class="selectpicker show-menu-arrow {{ $errors->has('terminal_id') ? ' has-danger' : '' }}"
                                        data-style="btn-primary" data-width="100%" data-live-search="true">
                                        @foreach ($terminals as $terminal)
                                            <option value="{{ $terminal->id }}">{{ $terminal->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('terminal_id'))
                                        <span id="name-terminal_id" class="error text-danger"
                                            for="input-terminal_id">{{ $errors->first('terminal_id') }}</span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('month_id') ? ' has-danger' : '' }} col-sm-3">
                                    <select id="input-month_id" name="month_id"
                                        class="selectpicker show-menu-arrow {{ $errors->has('month_id') ? ' has-danger' : '' }}"
                                        data-style="btn-primary" data-width="100%" data-live-search="true">
                                        @foreach ($months as $month)
                                            @if ($actualMonth >= $month['id'])
                                                <option value="{{ $month['id'] }}" @if ($actualMonth == $month['id']) selected @endif>{{ $month['name'] }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('month_id'))
                                        <span id="name-month_id" class="error text-danger"
                                            for="input-month_id">{{ $errors->first('month_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                @if (auth()->user()->roles->last()->id == 2)
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title text-center">Precio de gasolina</h5>
                                                <div class="bg-success text-white" id="regularprice">
                                                    {{ 'Regular: $' . ($pricesclient != null ? $pricesclient->regular : 0) }}
                                                </div>
                                                <div class="bg-danger text-white" id="premiumprice">
                                                    {{ 'Premium: $' . ($pricesclient != null ? $pricesclient->premium : 0) }}
                                                </div>
                                                <div class="bg-dark text-white" id="dieselprice">
                                                    {{ 'Diésel: $' . ($pricesclient != null ? $pricesclient->diesel : 0) }}
                                                </div>
                                                <p class="text-justify">
                                                    {{ __('Costo de producto en terminal de abastecimiento. No incluye flete.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div id="carouselExampleIndicators0" class="carousel slide col-lg-9 col-md-12 col-sm-12"
                                    data-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="row justify-content-center">
                                                <h4 class="text-white bg-success col-9">
                                                    {{ __('Gráfica de competencia regular') }}</h4>
                                                <canvas id="Regular" class="col-12"></canvas>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <div class="row justify-content-center">
                                                <h4 class="text-white bg-danger col-9">
                                                    {{ __('Gráfica de competencia premium') }}</h4>
                                                <canvas id="Premium" class="col-12"></canvas>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <div class="row justify-content-center">
                                                <h4 class="text-white bg-dark col-9">
                                                    {{ __('Gráfica de competencia diesel') }}</h4>
                                                <canvas id="Diesel" class="col-12"></canvas>
                                            </div>
                                        </div>
                                        <h6>{{ __('Días Transcurridos') }}</h6>
                                        <a class="carousel-control-prev" href="#carouselExampleIndicators0" role="button"
                                            data-slide="prev">
                                            <span class="text-dark" aria-hidden="true">
                                                <i class="material-icons" style="font-size: 50px;">keyboard_arrow_left</i>
                                            </span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleIndicators0" role="button"
                                            data-slide="next">
                                            <span class="text-dark" aria-hidden="true">
                                                <i class="material-icons" style="font-size: 50px;">keyboard_arrow_right</i>
                                            </span>
                                        </a>
                                    </div>
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
        let pricesR = arrayPrices('r', @json($prices));
        let pricesP = arrayPrices('p', @json($prices));
        let pricesD = arrayPrices('d', @json($prices));

        let chartRegular = new Chart(document.getElementById("Regular").getContext('2d'),
            configChart(pricesR, @json($days)));

        let chartPremium = new Chart(document.getElementById("Premium").getContext('2d'),
            configChart(pricesP, @json($days)));
        let chartDiesel = new Chart(document.getElementById("Diesel").getContext('2d'),
            configChart(pricesD, @json($days)));

        $(".selectpicker").change(function() {
            let terminal_id = document.getElementById('input-terminal_id').value;
            let month = document.getElementById('input-month_id').value;
        });
        $('#input-terminal_id').change(function() {
            let terminal_id = document.getElementById('input-terminal_id').value;
            let month = document.getElementById('input-month_id').value;
            getPrices(terminal_id, month);
        });
        $('#input-month_id').change(function() {
            let terminal_id = document.getElementById('input-terminal_id').value;
            let month = document.getElementById('input-month_id').value;
            getPrices(terminal_id, month);
        });

        async function getPrices(terminal, month) {
            try {
                const resp = await fetch('{{ url('') }}/pricesterminal/' + terminal + '/' + month);
                const prices = await resp.json();
                console.log(prices);
                if (prices.pricesclient != null) {
                    document.getElementById('regularprice').innerHTML = `Regular: $${prices.pricesclient.regular}`;
                    document.getElementById('premiumprice').innerHTML = `Premium: $${prices.pricesclient.premium}`;
                    document.getElementById('dieselprice').innerHTML = `Diesel: $${prices.pricesclient.diesel}`;
                } else {
                    if ("{{ auth()->user()->roles->first()->id == 2 }}") {
                        document.getElementById('regularprice').innerHTML = `Regular: $0`;
                        document.getElementById('premiumprice').innerHTML = `Premium: $0`;
                        document.getElementById('dieselprice').innerHTML = `Diesel: $0`;
                    }
                }
                chartRegular.destroy();
                chartPremium.destroy();
                chartDiesel.destroy();

                pricesR = arrayPrices('r', prices.prices);
                pricesP = arrayPrices('p', prices.prices);
                pricesD = arrayPrices('d', prices.prices);
                // enviar numero de dias
                chartRegular = new Chart(document.getElementById("Regular").getContext('2d'),
                    configChart(pricesR, prices.days));
                chartPremium = new Chart(document.getElementById("Premium").getContext('2d'),
                    configChart(pricesP, prices.days));
                chartDiesel = new Chart(document.getElementById("Diesel").getContext('2d'),
                    configChart(pricesD, prices.days));
            } catch (error) {
                console.log(error)
            }
        }

        function arrayPrices(product, array) {
            let prices = [];
            array.forEach(element => {
                prices.push({
                    label: element.alias,
                    data: product == 'r' ? element.regular : product == 'p' ?
                        element.premium : element.diesel,
                    //Color de fondo representativo de la competencia
                    backgroundColor: false,
                    // Color de borde de la competencia
                    borderColor: [`rgb(${hexToRgb(element.color)})`],
                    fill: false,
                    tension: 0.1,
                    // Tmaño de del borde
                    borderWidth: 2.5,
                });
            });
            return prices;
        }
        // recibir numero de dias por parametro
        function configChart(prices, days) {
            let config = {
                type: 'line',
                data: {
                    // Fechas 1-30,31,29
                    labels: days,
                    // Precios del competidor
                    datasets: prices,
                },
                options: {
                    responsive: true,
                    legend: {
                        display: screen.width > 700 ? true : false,
                        position: 'left',
                        align: 'start',
                    },
                },
            };
            return config;
        }
        // Metodo para convertir de HEX a RGB
        function hexToRgb(hex) {
            let result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            if (result) {
                let color = [];
                color.push(parseInt(result[1], 16));
                color.push(parseInt(result[2], 16));
                color.push(parseInt(result[3], 16));
                return color;
            }
            return [0, 0, 0];
        }
    </script>
@endpush
