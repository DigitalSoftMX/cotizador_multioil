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
                            <div class="row justify-content-md-start">
                                <div class="form-group{{ $errors->has('company_id') ? ' has-danger' : '' }} col-sm-3">
                                    <select id="input-company_id" name="company_id"
                                        class="selectpicker show-menu-arrow {{ $errors->has('company_id') ? ' has-danger' : '' }}"
                                        data-style="btn-primary" data-width="100%" data-live-search="true">
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('company_id'))
                                        <span id="name-company_id" class="error text-danger"
                                            for="input-company_id">{{ $errors->first('company_id') }}</span>
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
        let colors = [];
        colors.push([16, 211, 25]);
        colors.push([16, 87, 171]);
        colors.push([211, 16, 34]);
        colors.push([211, 16, 161]);
        colors.push([16, 176, 211]);
        colors.push([210, 216, 8]);
        colors.push([216, 122, 8]);
        colors.push([216, 56, 8]);
        colors.push([169, 216, 8]);

        let pricesR = arrayPrices('r', @json($prices));
        let pricesP = arrayPrices('p', @json($prices));
        let pricesD = arrayPrices('d', @json($prices));

        let chartRegular = new Chart(document.getElementById("Regular").getContext('2d'), configChart(pricesR));
        let chartPremium = new Chart(document.getElementById("Premium").getContext('2d'), configChart(pricesP));
        let chartDiesel = new Chart(document.getElementById("Diesel").getContext('2d'), configChart(pricesD));

        $(".selectpicker").change(function() {
            let company_id = document.getElementById('input-company_id').value;
            let month = document.getElementById('input-month_id').value;
        });
        $('#input-company_id').change(function() {
            let company_id = document.getElementById('input-company_id').value;
            let month = document.getElementById('input-month_id').value;
            getPrices(company_id, month);
        });
        $('#input-month_id').change(function() {
            let company_id = document.getElementById('input-company_id').value;
            let month = document.getElementById('input-month_id').value;
            getPrices(company_id, month);
        });

        async function getPrices(terminal, month) {
            try {
                const resp = await fetch('{{ url('') }}/pricescompany/' + terminal + '/' + month);
                const prices = await resp.json();
                console.log(prices);
                chartRegular.destroy();
                chartPremium.destroy();
                chartDiesel.destroy();

                pricesR = arrayPrices('r', prices.prices);
                pricesP = arrayPrices('p', prices.prices);
                pricesD = arrayPrices('d', prices.prices);

                chartRegular = new Chart(document.getElementById("Regular").getContext('2d'), configChart(pricesR));
                chartPremium = new Chart(document.getElementById("Premium").getContext('2d'), configChart(pricesP));
                chartDiesel = new Chart(document.getElementById("Diesel").getContext('2d'), configChart(pricesD));
            } catch (error) {
                console.log(error)
            }
        }

        function arrayPrices(product, array) {
            let prices = [];
            let i = 0;
            array.forEach(element => {
                prices.push({
                    label: element.name,
                    data: product == 'r' ? element.regular : product == 'p' ?
                        element.premium : element.diesel,
                    //Color de fondo representativo de la competencia
                    backgroundColor: ['rgb(255, 255, 255,0)'],
                    // Color de borde de la competencia
                    borderColor: [`rgb(${colors[i]})`],
                    // Tmaño de del borde
                    borderWidth: 3,
                });
                i++;
            });
            return prices;
        }

        function configChart(prices) {
            let config = {
                type: 'line',
                data: {
                    // Fechas 1-30,31,29
                    labels: @json($days),
                    // Preios del competidor
                    datasets: prices,
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Chart.js Line Chart'
                        }
                    }
                },
            };
            return config;
        }

    </script>
@endpush
