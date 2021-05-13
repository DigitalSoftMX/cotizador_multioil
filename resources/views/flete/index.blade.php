@extends('layouts.app', ['activePage' => 'flete', 'titlePage' => __('Generar costo aproximado de flete')])
@section('content')
    <div class="content">
        <div class="container-fluid mt-5">

            <div class="row">
                <div class="card card-nav-tabs">
                    <div class="card-header card-header-primary">
                        Flete
                    </div>
                    <div class="card-body">
                        {{-- Mapa --}}
                        <div class="row mt-3">
                            <div class="form-group col-md-4">
                                <label for="input-razon_social">
                                    {{ __('Lugar de origen') }}
                                </label>
                                <select class="custom-select custom-select-sm" id="origin">
                                    @foreach ($locations as $location)
                                        <option value="{{ $location['latitude'] . ',' . $location['longitude'] }}">
                                            {{ $location['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4 mt-3">
                                <label class="pl-2" for="destination">{{ __('Ingresa la dirección de destino') }}</label>
                                <input class="form-control mt-3" type="text" id="destination" onFocus="geolocate()"
                                    placeholder="" required value="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="input-razon_social">
                                    Cantidad
                                </label>
                                <select class="custom-select custom-select-sm" id="litros">
                                    <option value="4000" selected>
                                        {{ __('4,000 Lts') }}
                                    </option>
                                    <option value="21000">
                                        {{ __('21,000 Lts') }}
                                    </option>
                                    <option value="31000">
                                        {{ __('31,000 Lts') }}
                                    </option>
                                    <option value="42000">
                                        {{ __('42,000 Lts') }}
                                    </option>
                                    <option value="62000">
                                        {{ __('62,000 Lts') }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-3">
                                <button type="buttom" class="btn btn-block btn-primary pl-2" id="calcular">Calcular</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="text-center" id="prev-map" style="display: none;">
                                    <h4>Calculando distancia...</h4>
                                </div>
                                <div id="map" style="margin-top: 0px; max-height: 310px;"></div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group col-12 pl-0">
                                    <label for="costo-envio">{{ __('Costo por envio por litro ($) aproximado*') }}</label>
                                    <input class="form-control" type="text" id="costo-envio" readonly required>
                                </div>
                                <div class="form-group col-12 pl-0">
                                    <label for="distancia-recorrer">{{ __('Distancia total (km)') }}</label>
                                    <input class="form-control" type="text" id="distancia-recorrer" readonly>
                                </div>
                                <div class="form-group col-12 pl-0">
                                    <label for="monto-total">{{ __('Monto total de traslado ($)') }}</label>
                                    <input class="form-control" type="text" id="monto-total" readonly>
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

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAcnudyvCDSdVD9dAMBTUpZWIE-2t7h0A&libraries=places&callback=initAutocomplete&v=weekly"
        defer>
    </script>
    <script>
        "use strict";
        let destination, total_km;

        document.getElementById('calcular').addEventListener("click", (e) => {
            let dest = document.getElementById('destination').value;
            if (dest != '') {
                document.getElementById('prev-map').style.display = "block";
                document.getElementById('map').style.display = "none";
                // console.log(destination);
                let coordinates = document.getElementById("origin").value;
                let latitude = coordinates.split(',')[0];
                let longitude = coordinates.split(',')[1];
                initMap(latitude, longitude);
            } else {
                document.getElementById('map').style.display = "block";
                document.getElementById('prev-map').style.display = "none";
                alert("Ingrese una dirección de destino");
            }
        });

        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    destination.setBounds(circle.getBounds());
                });
            }
        }

        function initAutocomplete() {
            destination = new google.maps.places.Autocomplete(
                document.getElementById('destination'), {
                    types: ['geocode']
                });
            destination.setFields(['address_component', 'geometry']);
            destination.addListener('place_changed', fillInAddress);
        }

        function initMap(latitude, longitude) {
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 10,
                center: {
                    lat: 19.03793,
                    lng: -98.20346
                } // Mexico.
            });

            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer({
                draggable: true,
                map
            });

            directionsRenderer.addListener("directions_changed", () => {
                computeTotalDistance(directionsRenderer.getDirections());
            });

            displayRoute(
                // calcular el origen
                new google.maps.LatLng(latitude, longitude),
                destination.getPlace().geometry.location,
                directionsService,
                directionsRenderer
            );
        }

        function displayRoute(origin, destination, service, display) {
            service.route({
                    origin: origin,
                    destination: destination,
                    travelMode: google.maps.TravelMode.DRIVING,
                    avoidTolls: true
                },
                (result, status) => {
                    if (status === "OK") {
                        display.setDirections(result);
                    } else {
                        alert("No se pudieron mostrar las indicaciones debido a: " + status);
                    }
                }
            );
        }

        function computeTotalDistance(result) {
            let total = 0;
            const myroute = result.routes[0];

            total = myroute.legs[0].distance.text;
            total_km = myroute.legs[0].distance.value / 1000;

            document.getElementById("distancia-recorrer").value = total;
            document.getElementById('prev-map').style.display = "none";
            document.getElementById('map').style.display = "block";
            cotizar_viaje();
        }

        function cotizar_viaje() {
            let total_envio = 0;
            let distancia_recorrer = parseFloat(total_km);
            let litros = document.getElementById("litros").value;

            // [ km-max, precio ] *El precio lo calculo con la formula, sin embargo deje los costos de la tabla que se me envio
            //                      por si se necesitan despues
            let niveles = [
                [25.99, 0.17],
                [50.99, 0.19],
                [75.99, 0.21],
                [100.99, 0.23],
                [125.99, 0.25],
                [150.99, 0.26],
                [175.99, 0.31],
                [200.99, 0.33],
                [225.99, 0.36],
                [250.99, 0.38],
                [275.99, 0.39],
                [300.99, 0.42],
                [325.99, 0.45],
                [350.99, 0.47],
                [375.99, 0.50],
                [400.99, 0.52],
                [425.99, 0.55],
                [450.99, 0.57],
                [475.99, 0.60],
                [500.99, 0.62],
                [525.99, 0.64],
                [550.99, 0.66],
                [575.99, 0.69],
                [600.99, 0.71],
                [625.99, 0.74],
                [650.99, 0.76],
                [675.99, 0.78],
                [700.99, 0.81],
                [725.99, 0.84],
                [750.99, 0.86],
                [775.99, 0.88],
                [800.99, 0.89],
                [825.99, 0.92],
                [850.99, 0.94],
                [875.99, 1.00],
                [900.99, 0.99],
                [925.99, 1.02],
                [950.99, 1.04],
                [975.99, 1.07],
                [1000.99, 1.08],
                [1200.99, 1.11],
                [1400.99, 1.13],
                [1600.99, 1.16],
                [1800.99, 1.18],
                [2000, 1.21]
            ];

            for (let i = 0; i < niveles.length; i++) {
                if (distancia_recorrer < niveles[i][0]) {
                    total_envio = niveles[i][1] + 0.10;
                    break;
                }
            }

            let monto = total_envio * litros;

            document.getElementById("costo-envio").value = total_envio.toFixed(3);
            document.getElementById("monto-total").value = '$ ' + monto.toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,') +
                " (Precio sin IVA)";
        }

    </script>
@endpush
