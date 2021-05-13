<div class="card">

    <div class="card-body text-center mt-3 mb-3">
        @if($gasolina != 'Diésel')
        @endif

        <h6 class="card-title">Con aditivo sumar $0.14 centavos.</h6>
    </div>

    <div class="card-body" width="100%" height=50px>
        <h5 class="card-header text-white {{$color}}">Gráfica de competencia
            {{$terminal}} Valero {{$gasolina}} - Pemex {{$gasolinaP}}</h5>
        <canvas id="{{$gasolina.$terminal}}"></canvas>
        <h6>Días Transcurridos</h6>
        <?php

        if(auth()->user()->roles[0]->id == 2){
            $precios = array();
            $posicion_ultima_fecha = array();

            if ($precio_pemex != NULL) {
                $precios['Pemex'] = $precio_pemex[count($precio_pemex)-1];
                $posicion_ultima_fecha['Pemex'] = count($precio_pemex)-1;
            }

        }
        else{
             $precios = array();

            if ($vector_precio_valero != NULL) {
                 $precios['Valero'] = $vector_precio_valero[count($vector_precio_valero)-1];
                 $posicion_ultima_fecha['Valero'] = count($vector_precio_valero)-1;
             }
             if ($precio_pemex != NULL) {
                 $precios['Pemex'] = $precio_pemex[count($precio_pemex)-1];
                 $posicion_ultima_fecha['Pemex'] = count($precio_pemex)-1;
             }
             if ($precio_policon != NULL) {
                 $precios['Policon'] = $precio_policon[count($precio_policon)-1];
                 $posicion_ultima_fecha['Policon'] = count($precio_policon)-1;
             }
             if ($precio_energo != NULL) {
                 $precios['Energo'] = $precio_energo[count($precio_energo)-1];
                 $posicion_ultima_fecha['Energo'] = count($precio_energo)-1;
             }
        }

        array_multisort($precios);
        ?>
        <div class="row text-center">
            @foreach($precios as $key => $value)
                @if( auth()->user()->roles[0]->id == 1 )
                    <div class="col-3 mx-auto d-block">
                        <div class="card">
                          <div class="card-body">
                            <h6 class="card-title">
                                Precio del ultimo día registrado para: {{$key}}
                                <br>

                                @php
                                    $ultima_fecha = $fechas[ $posicion_ultima_fecha[$key] ]."-".date("Y");
                                    $ultima_fecha = str_replace(' ', '', $ultima_fecha);
                                @endphp

                                {{ $ultima_fecha }}

                            </h6>
                            <h5 class="card-title">$
                                {{ $value }}
                            </h5>
                          </div>
                        </div>
                    </div>
                @else

                    @if($key === 'Pemex')
                        <div class="col-3 mx-auto d-block">
                            <div class="card">
                              <div class="card-body">
                                <h6 class="card-title">
                                    Precio del ultimo día registrado para: {{$key}}
                                    <br>

                                    @php
                                        $ultima_fecha = $fechas[ $posicion_ultima_fecha[$key] ]."-".date("Y");
                                        $ultima_fecha = str_replace(' ', '', $ultima_fecha);
                                    @endphp

                                    {{ $ultima_fecha }}

                                </h6>
                                <h5 class="card-title">$
                                    {{ $value }}
                                </h5>
                              </div>
                            </div>
                        </div>
                    @endif

                @endif
            @endforeach

        </div>

    </div>
</div>
@php
@endphp
@push('js')
<script>
    $( document ).ready(function() {
        var ctx = document.getElementById('{{$gasolina.$terminal}}').getContext('2d');
        var config = {
            type: 'line',
            data: {
                // Fechas 1-30,31,29
                labels: @json($fechas),
                // Informacion de los competidores
                datasets: [
                    @if(auth()->user()->roles[0]->id == 1)
                    {
                        // Informacion del competidor Valero
                        // Nombre del competidor Valero
                        label: 'Valero',
                        // Valores en la columna y (precios)
                        data: @json($vector_precio_valero),
                        //Color de fondo representativo de la competencia
                        backgroundColor: ['rgb(255, 255, 255,0)'],
                        // Color de borde de la competencia
                        borderColor: ['rgb(16, 87, 171)'],
                        // Tmaño de del borde
                        borderWidth: 3,
                    },
                    @endif
                    {
                        // Informacion del competidor Pemex
                        label: 'Pemex',
                        data: @json($precio_pemex),
                        backgroundColor: ['rgb(255, 255, 255,0)'],
                        borderColor: ['rgb(0, 116, 55)'],
                        borderWidth: 3
                    },
                    @if(auth()->user()->roles[0]->id == 1)
                    {
                        // Informacion del competidor policon
                        label: 'Policon',
                        data: @json($precio_policon),
                        backgroundColor: ['rgb(255, 255, 255, 0)'],
                        borderColor: ['rgb(223, 1, 31)'],
                        borderWidth: 3
                    },
                    @endif
                    @if(auth()->user()->roles[0]->id !== 3 && auth()->user()->roles[0]->id !== 2 && auth()->user()->roles[0]->id !== 4 )
                    @endif
                ],

            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: false,
                            stepSize: 0.5
                        }
                    }],
                }
            }
        };

        var myLineChart = new Chart(ctx, config);


        $("#fecha").change(function() {

            myLineChart.destroy();
            $.ajax({
                url: 'fechas',
                type: 'POST',
                dataType: 'json',
                data: {
                  '_token': $('input[name=_token]').val(),
                  'fecha' : $('#fecha').val(),
                  'combustible' : '{{ $gasolina }}',
                  'id_terminal' : '{{ $id_terminal }}',
                },
                headers:{
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    var datos =  response;
                    // config de buscar por fecha

                    var config_fechas = {
                        type: 'line',
                        data: {
                            labels: datos.fechas,
                            datasets: [
                                @if(auth()->user()->roles[0]->id == 1)
                                {
                                    label: 'Valero',
                                    data: datos.precios_valero,
                                    backgroundColor: ['rgb(255, 255, 255,0)'],
                                    borderColor: ['rgb(16, 87, 171)'],
                                    borderWidth: 3,
                                },
                                @endif
                                {
                                    label: 'Pemex',
                                    data: datos.precios_pemex,
                                    backgroundColor: ['rgb(255, 255, 255,0)'],
                                    borderColor: ['rgb(0, 116, 55)'],
                                    borderWidth: 3
                                },
                                @if(auth()->user()->roles[0]->id == 1)
                                {
                                    label: 'Policon',
                                    data: datos.precios_policon,
                                    backgroundColor: ['rgb(255, 255, 255, 0)'],
                                    borderColor: ['rgb(223, 1, 31)'],
                                    borderWidth: 3
                                },
                                @endif
                                @if(auth()->user()->roles[0]->id == 1)
                                /*
                                {
                                    label: 'Energo',
                                    data: datos.precios_energo,
                                    backgroundColor: ['rgb(255, 255, 255, 0)'],
                                    borderColor: ['rgb(0, 196, 196)'],
                                    borderWidth: 3
                                },
                                */
                                @endif
                                @if(auth()->user()->roles[0]->id !== 3 && auth()->user()->roles[0]->id !== 2 && auth()->user()->roles[0]->id !== 4)
                                @endif
                            ]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: false,
                                        stepSize: 0.5
                                    }
                                }],
                            },
                        }
                    };

                    console.log(datos.precios_pemex);
                    myLineChart = new Chart(ctx, config_fechas);

                },
                error: function(xhr){
                    alert("An error occured: " + xhr.status + " " + xhr.statusText);
                }
            });
        });
    });


</script>
@endpush
