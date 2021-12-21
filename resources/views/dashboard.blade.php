@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
    <div
        style="background:white; width:100%; height: 70vh; background: #ffffff; box-shadow: 0 3px 10px rgb(0 0 0 / 0.2); border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
        <div class="row">
            <div class="card-body">
                <div class="row justify-content-center">

                    <div id="carouselExampleIndicators0" class="carousel slide col-lg-12 col-md-12 col-sm-12"
                        data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="row justify-content-center">
                                    <h4 class="text-white font-weight-bold col-9">
                                        {{ __('Gráfica de competencia regular') }}</h4>
                                    <canvas id="Regular" class="col-12"></canvas>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="row justify-content-center">
                                    <h4 class="text-white font-weight-bold col-9">
                                        {{ __('Gráfica de competencia premium') }}</h4>
                                    <canvas id="Premium" class="col-12"></canvas>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="row justify-content-center">
                                    <h4 class="text-white font-weight-bold col-9">
                                        {{ __('Gráfica de competencia diesel') }}</h4>
                                    <canvas id="Diesel" class="col-12"></canvas>
                                </div>
                            </div>
                            <h6 class="text-white">{{ __('Días Transcurridos') }}</h6>

                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators0" role="button" data-slide="prev">
                        <span class="text-dark" aria-hidden="true">
                            <i class="material-icons" style="font-size: 50px; color:blue;">keyboard_arrow_left</i>
                        </span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators0" role="button" data-slide="next">
                        <span class="text-dark" aria-hidden="true">
                            <i class="material-icons" style="font-size: 50px; color:blue;">keyboard_arrow_right</i>
                        </span>
                    </a>
                </div>


                @include('partials.notification')
                <div class="row mt-3 pl-5 pr-5">
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
                                    <option value="{{ $month['id'] }}" @if ($actualMonth == $month['id']) selected @endif>{{ $month['name'] }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @if ($errors->has('monTth_id'))
                            <span id="name-month_id" class="error text-danger"
                                for="input-month_id">{{ $errors->first('month_id') }}</span>
                        @endif
                    </div>
                    @if (auth()->user()->roles->first()->id == 2)
                        <div class="col-md-6 text-right">
                            <a href="{{ route('getshopping', auth()->user()->company_id) }}"
                                class="btn btn-sm btn-success">{{ __('Ver mi estado de cuenta') }}</a>
                        </div>
                    @endif
                    @if (auth()->user()->roles->first()->id == 1)
                        <div class="col-md-6 text-right pt-3">
                            <a href="{{ route('prices.index') }}" class="btn btn-sm btn-success">
                                {{ __('Capturar precios') }}
                            </a>
                        </div>
                    @endif
                </div>


            </div>
        </div>
    </div>
    @if (auth()->user()->roles->last()->id == 2)
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <h5 class="card-title text-center">Precio de gasolina</h5>
                        </div>
                        <div class="row">
                            <div class="col bg-success text-white mx-1" id="regularprice">
                                {{ 'Regular: $' . ($pricesclient != null ? $pricesclient->regular : 0) }}
                            </div>
                            <div class="col bg-danger text-white mx-1" id="premiumprice">
                                {{ 'Premium: $' . ($pricesclient != null ? $pricesclient->premium : 0) }}
                            </div>
                            <div class="col bg-dark text-white mx-1" id="dieselprice">
                                {{ 'Diésel: $' . ($pricesclient != null ? $pricesclient->diesel : 0) }}
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <p class="text-justify">
                                {{ __('* Costo de producto en terminal de abastecimiento. No incluye flete.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (auth()->user()->roles->first()->id == 1)
        <div class="content pt-0 mt-0">
            <div class="container-fluid pt-0 mt-0">
                <div class="row pt-0 mt-0">
                    <div class="col-sm-6">
                        <div class="row pt-0 mt-0">
                            <div class="col-md-12 pt-0 mt-0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-stats pt-0 mt-0">
                                            <div class="card-body">
                                                <div class="statistics text-center">
                                                    <h3 class="info-title">{{ $totalCompanys }}</h3>
                                                    <h6 class="stats-title">Clientes totales</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ju">
                                        <div class="card card-stats pt-0 mt-0">
                                            <div class="card-body">
                                                <div class="statistics text-center">
                                                    <h3 class="info-title">{{ $totalOrders }}</h3>
                                                    <h6 class="stats-title">pedidos totales</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12 pt-0 mt-0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-stats pt-0 mt-0">
                                            <div class="card-body">
                                                <div class="statistics text-center">
                                                    <h3 class="info-title">
                                                        <!--small>$</small-->{{ number_format($totalLiters, 2) }}
                                                    </h3>
                                                    <h6 class="stats-title">Litros totales</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card card-stats pt-0 mt-0">
                                            <div class="card-body">
                                                <div class="statistics text-center">
                                                    <h3 class="info-title">
                                                        <small>$</small>{{ number_format($totalMoney, 2) }}
                                                    </h3>
                                                    <h6 class="stats-title">total</h6>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card scroll-card-active mt-0 pt-0" style="height: 38vh;">
                            <div class="card-body">
                                <h4 class="font-weight-bold">Clientes</h4>
                                <div class="row m-0 pl-2 pr-2 pt-0 pb-0">
                                    <div class="table-full-width table-responsive col-sm-12 m-0 mr-0 ml-0 pr-0 pl-0">
                                        <table class="table table-shopping">
                                            <tbody>
                                                @foreach ($prices as $link)
                                                    <tr>
                                                        <td>
                                                            <div class="text-center"
                                                                style="height: 35px; width: 35px; background: {{ $link['color'] }}; border-radius: 30px; align-items: center; display: flex; justify-content: center; color:white">
                                                                <p class="card-subtitle">{{ $link['name'][0] }}</p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class=" card-subtitle">{{ $link['name'] }}</p>
                                                            <!--p class="mb-1">{{-- $link['alias'] --}}</p-->
                                                        </td>
                                                        <td class="td-actions text-right">
                                                            <a class="btn btn-danger btn-link p-0 m-0"
                                                                data-original-title="" rel="tooltip"
                                                                title="Ver información del cliente"
                                                                href="{{ route('showcompanie', $link['id']) }}">
                                                                <i
                                                                    class="material-icons text-success">keyboard_arrow_right</i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-4">
                        <div class="card scroll-card-active" style="height: 55vh;">
                            <div class="card-body">
                                <h4 class="font-weight-bold">IVA</h4>
                                <div class="row m-0 pl-2 pr-2 pt-0 pb-0">
                                    <div class="table-full-width table-responsive col-sm-12 m-0 mr-0 ml-0 pr-0 pl-0">
                                        <table class="table table-shopping">
                                            <tbody id="ivapormes"></tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="col-sm-8">
                        <div class="card ps-active-y" style="height: 55vh;">
                            <div class="card-body">
                                <h4 class=" font-weight-bold">Litros vendidos por mes</h4>
                                <canvas id="chartBig1L" class="pb-3"></canvas>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-5">
                        <div class="card" style="height: 60vh;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-7">
                                        <p class="h4 font-weight-bold pt-2">Gasto total por transporte</p>
                                    </div>
                                    <div class="col-5">
                                        <input type="text" name="daterange" class="pt-2"
                                            style="border: none; border-bottom: 2px solid #000;" />
                                    </div>
                                </div>

                                <div class="tab-pane active show" id="profil">
                                    <canvas id="chartBigTransport"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="card ps-active-y" style="height: 60vh;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                        <p class="h4 font-weight-bold pt-2">Litros vendidos por producto</p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <select id="chsngeDaysMounts" class="selectpicker show-menu-arrow"
                                            data-width="80%">
                                            <option value="0">Días</option>
                                            <option value="1">Meses</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="nav-tabs-navigation">
                                    <div class="nav-tabs-wrapper">
                                        <ul class="nav nav-tabs" data-tabs="tabs" style="justify-content: flex-end;">
                                            <li class="nav-item" id="prod0">
                                                <a class="nav-link active show text-primary" href="#profile"
                                                    data-toggle="tab">
                                                    <i class="material-icons ">local_gas_station</i>
                                                    Regular
                                                </a>
                                            </li>
                                            <li class="nav-item" id="prod1">
                                                <a class="nav-link text-primary" href="#messages" data-toggle="tab">
                                                    <i class="material-icons ">local_gas_station</i>
                                                    Premium
                                                </a>
                                            </li>
                                            <li class="nav-item" id="prod2">
                                                <a class="nav-link text-primary" href="#settings" data-toggle="tab">
                                                    <i class="material-icons">local_gas_station</i>
                                                    Diésel
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-content pb-3">
                                    <div class="tab-pane active show" id="profile">
                                        <canvas id="chartBigProducts"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="card" style="height: 60vh;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-7">
                                        <p class="h4 font-weight-bold pt-2">Gastos por empresa de transporte</p>
                                    </div>
                                    <div class="col-5 text-right">
                                        <select id="lastMounts" class="selectpicker show-menu-arrow" data-width="100%">
                                            <option value="0">últimos 12 meses</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="tab-pane active show" id="TransportCompany">
                                    <lottie-player id="chartTransportCompany" class="mx-auto d-block"
                                        src="https://assets5.lottiefiles.com/packages/lf20_Z4BhGL.json"
                                        background="transparent" speed="1"
                                        style="width: 200px; height: 200px; margin-top: 50px;" loop autoplay>
                                    </lottie-player>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card ps-active-y" style="height: 60vh;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-7">
                                        <p class="h4 font-weight-bold pt-2">Total importe factura por la guerrera</p>
                                    </div>
                                    <div class="col-5 text-right">
                                        <select id="lastMountsGuerrera" class="selectpicker show-menu-arrow"
                                            data-width="100%">
                                            <option value="0">Total</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="tab-content pb-3">
                                    <div class="tab-pane active show" id="guerrera">
                                        <lottie-player id="chartTransportGuerrera" class="mx-auto d-block"
                                            src="https://assets5.lottiefiles.com/packages/lf20_Z4BhGL.json"
                                            background="transparent" speed="1"
                                            style="width: 200px; height: 200px; margin-top: 50px;" loop autoplay>
                                        </lottie-player>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card" style="height: 60vh;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-7">
                                        <p class="h4 font-weight-bold pt-2">Total importe factura por Valero</p>
                                    </div>
                                    <div class="col-5 text-right">
                                        <select id="ValeroGuerreralastMounts" class="selectpicker show-menu-arrow"
                                            data-width="50%">
                                            <option value="0">últimos 12 meses</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tab-pane active show" id="ValeroGuerrera">
                                    <lottie-player id="chartValeroGuerrera" class="mx-auto d-block"
                                        src="https://assets5.lottiefiles.com/packages/lf20_Z4BhGL.json"
                                        background="transparent" speed="1"
                                        style="width: 200px; height: 200px; margin-top: 50px;" loop autoplay>
                                    </lottie-player>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card" style="height: 60vh;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-7">
                                        <p class="h4 font-weight-bold pt-2">Merma por cliente</p>
                                    </div>
                                    <div class="col-5 text-right">
                                        <select id="MermaporclientemeslastMounts" class="selectpicker show-menu-arrow"
                                            data-width="50%">
                                            <option value="0">últimos 12 meses</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="tab-pane active show" id="mermaporclientemes">
                                    <lottie-player id="chartMermaPorClientemes" class="mx-auto d-block"
                                        src="https://assets5.lottiefiles.com/packages/lf20_Z4BhGL.json"
                                        background="transparent" speed="1"
                                        style="width: 200px; height: 200px; margin-top: 50px;" loop autoplay>
                                    </lottie-player>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4 pr-5">
                        <div class="card scroll-card-active" style="height: 60vh;">
                            <div class="card-body">
                                <h4 class="font-weight-bold">Utilidad cliente</h4>
                                <div class="row m-0 pl-2 pr-2 pt-0 pb-0">
                                    <div class="table-full-width table-responsive col-sm-12 m-0 mr-0 ml-0 pr-0 pl-0">
                                        <table class="table table-shopping">
                                            <tbody id="utilidadcliente" class="">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 pr-3 pl-3">
                        <div class="card scroll-card-active" style="height: 60vh;">
                            <div class="card-body">
                                <h4 class="font-weight-bold">Utilidad general</h4>
                                <div class="row m-0 pl-2 pr-2 pt-0 pb-0">
                                    <div class="table-full-width table-responsive col-sm-12 m-0 mr-0 ml-0 pr-0 pl-0">
                                        <table class="table table-shopping">
                                            <tbody id="utilidadgeneral">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 pl-5">
                        <div class="card scroll-card-active" style="height: 60vh;">
                            <div class="card-body">
                                <h4 class="font-weight-bold">Utilidad guerrera</h4>
                                <div class="row m-0 pl-2 pr-2 pt-0 pb-0">
                                    <div class="table-full-width table-responsive col-sm-12 m-0 mr-0 ml-0 pr-0 pl-0">
                                        <table class="table table-shopping">
                                            <tbody id="utilidadguerrera">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    @endif
@endsection
@push('js')
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                //"autoApply": true,
                "startDate": formatDate(sumarDias(d, -30)),
                "endDate": new Date(),
                //"minDate": formatDate(sumarDias(d, -30)),
                "maxDate": new Date(),
                "opens": 'left',
                "locale": {
                    "applyLabel": "Aplicar",
                    "cancelLabel": "Cancelar",
                    "fromLabel": "De",
                    "daysOfWeek": [
                        "Dom",
                        "Lun",
                        "Mar",
                        "Mie",
                        "Jue",
                        "Vie",
                        "Sáb"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],

                }
            }, function(start, end, label) {
                //const val = document.getElementById("chsngeDaysMounts").value;
                chartTransport(4, start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'),
                    '{{ url('/') }}');
                //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });

        @if (auth()->user()->roles->last()->id == 1)
            const selectElement = document.querySelector('#chsngeDaysMounts');
            selectElement.addEventListener('change', (event) => {
            const val = document.getElementById("chsngeDaysMounts").value;
            chartProducts(val,'','','',45,'{{ url('/') }}');
            });
        
            const selectLastMount = document.querySelector('#lastMounts');
            selectLastMount.addEventListener('change', (event) => {
            const val = document.getElementById("lastMounts").value;
            chartTransportCompany('{{ url('/') }}','transporte',
            val,'doughnut','chartTransportCompany','TransportCompany',false,false, true);
            });
        
            const selectLastMountGuerrera = document.querySelector('#lastMountsGuerrera');
            selectLastMountGuerrera.addEventListener('change', (event) => {
            const val = document.getElementById("lastMountsGuerrera").value;
            chartTransportCompany('{{ url('/') }}','guerrera',val, 'bar','chartTransportGuerrera','guerrera',true,true,
            false);
            });
        
            const selectValeroGuerreralastMounts = document.querySelector('#ValeroGuerreralastMounts');
            selectValeroGuerreralastMounts.addEventListener('change', (event) => {
            const val = document.getElementById("ValeroGuerreralastMounts").value;
            chartTransportCompany('{{ url('/') }}','valeroguerrera',val,
            'line','chartValeroGuerrera','ValeroGuerrera',true,true,false);
            });
        
            const selectMermaporclientemeslastMounts = document.querySelector('#MermaporclientemeslastMounts');
            selectMermaporclientemeslastMounts.addEventListener('change', (event) => {
            const val = document.getElementById("MermaporclientemeslastMounts").value;
            chartTransportCompany('{{ url('/') }}','mermaporclientemes',val,
            'bar','chartMermaPorClientemes','mermaporclientemes',true,true,false);
            });
        @endif

        async function initChartsT() {
            const yourDate = new Date().toLocaleDateString('en-ZA');
            myFunction();
            chartProducts(0, '', '', '', 45, '{{ url('/') }}');
            chartTransport(4, formatDate(sumarDias(new Date(), -30)), yourDate, '{{ url('/') }}');
            await chartTransportCompany('{{ url('/') }}', 'transporte', '', 'doughnut', 'chartTransportCompany',
                'TransportCompany', false, false, true);
            await chartTransportCompany('{{ url('/') }}', 'guerrera', '', 'bar', 'chartTransportGuerrera',
                'guerrera', true, true, false);
            await chartTransportCompany('{{ url('/') }}', 'valeroguerrera', '', 'line', 'chartValeroGuerrera',
                'ValeroGuerrera', true, true, false);
            await chartTransportCompany('{{ url('/') }}', 'mermaporclientemes', '', 'bar',
                'chartMermaPorClientemes', 'mermaporclientemes', true, true, false);
            await initDashboardTable('{{ url('/') }}', 'utilidadcliente', '', 'utilidadcliente');
            await initDashboardTable('{{ url('/') }}', 'utilidadgeneral', '', 'utilidadgeneral');
            await initDashboardTable('{{ url('/') }}', 'utilidadguerrera', '', 'utilidadguerrera');
            await initDashboardTable('{{ url('/') }}', 'iva', '', 'ivapormes', 'month');
            await selectMouth('{{ url('/') }}', 0, 'lastMounts');
            await selectMouth('{{ url('/') }}', 0, 'lastMountsGuerrera');
            await selectMouth('{{ url('/') }}', 0, 'ValeroGuerreralastMounts');
            await selectMouth('{{ url('/') }}', 0, 'MermaporclientemeslastMounts');
        }

        // esto activa el scroll de la tarjeta
        $('.scroll-card-active').perfectScrollbar();

        let pricesR = arrayPrices('r', @json($prices));
        let pricesP = arrayPrices('p', @json($prices));
        let pricesD = arrayPrices('d', @json($prices));

        //console.log(pricesR);

        let chartRegular = new Chart(document.getElementById("Regular").getContext('2d'),
            configChart(pricesR, @json($days), 'Gráfica de competencia regular', 'green'));

        let chartPremium = new Chart(document.getElementById("Premium").getContext('2d'),
            configChart(pricesP, @json($days), 'Gráfica de competencia premium', 'red'));

        let chartDiesel = new Chart(document.getElementById("Diesel").getContext('2d'),
            configChart(pricesD, @json($days), 'Gráfica de competencia diesel', 'black'));



        // se modifica la proporcion de las graficas
        chartRegular.canvas.parentNode.style.height = '50vh';
        chartRegular.canvas.parentNode.style.width = '100%';

        chartPremium.canvas.parentNode.style.height = '50vh';
        chartPremium.canvas.parentNode.style.width = '100%';

        chartDiesel.canvas.parentNode.style.height = '50vh';
        chartDiesel.canvas.parentNode.style.width = '100%';


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
                    configChart(pricesR, prices.days, 'Gráfica de competencia regular', 'green'));
                chartPremium = new Chart(document.getElementById("Premium").getContext('2d'),
                    configChart(pricesP, prices.days, 'Gráfica de competencia premium', 'red'));
                chartDiesel = new Chart(document.getElementById("Diesel").getContext('2d'),
                    configChart(pricesD, prices.days, 'Gráfica de competencia diesel', 'black'));
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
                    backgroundColor: [`rgb(${hexToRgb(element.color)}, 0.9)`],
                    // Color de borde de la competencia
                    borderColor: [`rgb(${hexToRgb(element.color)})`],
                    fill: false,
                    tension: 0.3,
                    borderDashOffset: 0.0,
                    // Tamaño del borde
                    borderWidth: 2.5,
                });
            });
            return prices;
        }

        // chart labels
        function chartLabes(data, array) {
            let label = {
                //label: element.alias,
                data: data,
                //Color de fondo representativo de la competencia
                backgroundColor: [`rgb(${hexToRgb('#235ea5')}, 0.9)`],
                // Color de borde de la competencia
                borderColor: [`rgb(${hexToRgb('#235ea5')})`],
                fill: false,
                tension: 0.3,
                borderDashOffset: 0.0,
                // Tamaño del borde
                borderWidth: 2.5,
            };

            return label;
        }
        // recibir numero de dias por parametro
        function configChart(prices, days, title, colorTitle) {
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
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: title,
                            color: colorTitle,
                            font: {
                                size: 18,
                                weight: 'bold',
                            },
                        },
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                color: '#000'
                            },
                        },
                    },
                    interaction: {
                        intersect: false,
                    },
                    scales: {
                        x: {
                            grid: {
                                drawBorder: false,
                                color: 'transparent',
                            },
                            ticks: {
                                padding: 15,
                                color: "#235ea5"
                            },
                            title: {
                                display: true,
                                //alignment: 'start',
                                text: 'Días transcurridos',
                                //color: '#911',
                                font: {
                                    //family: 'Comic Sans MS',
                                    size: 14,
                                    weight: 'bold',
                                    lineHeight: 1.2,
                                },
                                padding: {
                                    top: 5,
                                    left: 0,
                                    right: 0,
                                    bottom: 10
                                }
                            }
                        },
                        y: {
                            //min: 17,
                            grid: {
                                drawBorder: false,
                                color: 'rgba(200,200,200, 0.3)',
                            },
                            ticks: {
                                padding: 15,
                                color: "#235ea5",
                                stepSize: 2
                            }
                        }
                    }
                },
            };
            return config;
        }
    </script>
@endpush
