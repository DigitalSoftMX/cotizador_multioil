@extends('layouts.app', ['activePage' => 'Empresas', 'titlePage' => __('Gráficas del cliente')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card ps-active-y" style="height: 55vh;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-7">
                                    <h4 class=" font-weight-bold pt-2">Litros vendidos por cliente</h4>
                                </div>
                                
                                <div class="col-sm-1 text-right">
                                    <p class="font-weight-bold pt-2">Rango</p>
                                </div>
                                <div class="col-sm-2 text-right">
                                    <input type="text" name="daterange" class="pt-2" style="border: none; border-bottom: 2px solid #000;"/>
                                </div>
                                <div class="col-2 text-right">
                                    <select id="chsngeDaysMounts" class="selectpicker show-menu-arrow" data-width="80%" >
                                        <option value="2">Días</option>
                                        <option value="3">Meses</option>
                                    </select>
                                </div>
                            </div>
                            <div class="nav-tabs-navigation">
                                <div class="nav-tabs-wrapper"> 
                                    <ul class="nav nav-tabs" data-tabs="tabs" style="justify-content: flex-end;">
                                        <li class="nav-item" id="prod0">
                                            <a class="nav-link active show text-primary" href="#profile" data-toggle="tab">
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
                                    <canvas id="chartBigProducts" class="pb-3"></canvas>
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
        

      

        const selectElement = document.querySelector('#chsngeDaysMounts');

        selectElement.addEventListener('change', (event) => {
            const val = document.getElementById("chsngeDaysMounts").value;
            //chartProducts(val,'2021-07-22' ,'2021-08-23',19);
        });

        $(function() {
            $('input[name="daterange"]').daterangepicker({
                //"autoApply": true,
                "startDate":formatDate(sumarDias(d, -30)),
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
                const val = document.getElementById("chsngeDaysMounts").value;
                chartProducts(val,start.format('YYYY-MM-DD') ,end.format('YYYY-MM-DD'),19);
                //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });

        function initChartsT(){
            const yourDate =  new Date().toLocaleDateString('en-ZA');
            //console.log(yourDate); // 2020/08/19 (year/month/day) notice the different locale
            //yourDate.toISOString().split('T')[0]
            chartProducts(2,formatDate(sumarDias(new Date(), -30)) ,yourDate,{{$company_id}},40);
        }
    </script>
@endpush