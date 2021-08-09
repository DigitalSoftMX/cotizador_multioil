@extends('layouts.app', ['activePage' => 'Flete', 'titlePage' => __('Generar costo aproximado de flete')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Flete') }}</h4>
                            <p class="card-category"> {{ __('Aquí puedes calcular el costo de un flete.') }}</p>
                        </div>
                        <div class="card-body">
                            @if (auth()->user()->roles()->first()->id == 1)
                                <div class="row">
                                    <div class="col-12 text-right">
                                        <a href="{{ route('levels.create') }}"
                                            class="btn btn-sm btn-primary">{{ __('Ver unidades-km-precio') }}</a>
                                    </div>
                                </div>
                            @endif
                            <div class="row mt-3">
                                <div class="form-group{{ $errors->has('origin') ? ' has-danger' : '' }} col-4">
                                    <select id="origin" name="origin"
                                        class="selectpicker show-menu-arrow {{ $errors->has('origin') ? ' has-danger' : '' }}"
                                        data-style="btn-primary" data-width="100%" data-live-search="true">
                                        <option value="">{{ __('Elija el lugar de origen') }}</option>
                                        @foreach ($terminals as $terminal)
                                            <option value="{{ $terminal }}">{{ $terminal->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- Mapa ubiación --}}
                                <div class="form-group col-md-4 mt-3">
                                    <label class="pl-2"
                                        for="destination">{{ __('Ingresa la dirección de destino') }}</label>
                                    <input class="form-control mt-2" type="text" id="destination" onFocus="geolocate()"
                                        placeholder="" required value="">
                                </div>
                                <div class="form-group{{ $errors->has('liters') ? ' has-danger' : '' }} col-4">
                                    <select id="liters" name="liters"
                                        class="selectpicker show-menu-arrow {{ $errors->has('liters') ? ' has-danger' : '' }}"
                                        data-style="btn-primary" data-width="100%" data-live-search="true">
                                        <option value="">{{ __('Elija la cantidad en litros') }}</option>
                                        <option value="20000">{{ __('20,000 Lts') }}</option>
                                        <option value="31000">{{ __('31,000 Lts') }}</option>
                                        <option value="62000">{{ __('62,000 Lts') }}</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <button type="button" class="btn btn-block btn-primary pl-2"
                                        id="calcular">{{ __('Calcular') }}</button>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-lg-8">
                                    <div class="text-center" id="prev-map" style="display: none;">
                                        <h4>Calculando distancia...</h4>
                                    </div>
                                    <div id="map" style="margin-top: 0px; max-height: 310px;"></div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group col-12 pl-0">
                                        <label for="costo-envio">
                                            {{ __('Costo de envío por litro ($) aproximado*') }}</label>
                                        <input class="form-control" type="text" id="costo-envio" readonly required>
                                    </div>
                                    <div class="form-group col-12 pl-0">
                                        <label for="distancia-recorrer">{{ __('Distancia total (kms)') }}</label>
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
            let origin = document.getElementById("origin").value;
            let dest = document.getElementById('destination').value;
            let liters = document.getElementById('liters').value;
            if (dest != '' && origin != '' && liters != '') {
                document.getElementById('prev-map').style.display = "block";
                document.getElementById('map').style.display = "none";
                origin = JSON.parse(origin);
                initMap(origin.latitude, origin.longitude);
            } else {
                document.getElementById('map').style.display = "block";
                document.getElementById('prev-map').style.display = "none";
                origin == '' ? alert('Ingrese una dirección de origen') :
                    dest == '' ? alert('Ingrese una dirección de destino') :
                    liters == '' ? alert('Ingrese la cantidad de litros') : '';
            }
        });

        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    let geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    let circle = new google.maps.Circle({
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

            document.getElementById('prev-map').style.display = "none";
            document.getElementById('map').style.display = "block";
            cotizar_viaje();
        }

        function cotizar_viaje() {
            let shipping = 0;
            let distance = parseFloat(total_km);
            let liters = document.getElementById("liters").value;
            let pipa = @json($pipa);
            let sencillo = @json($sencillo);
            let full = @json($full);
            let monto = 0;
            liters = parseInt(liters);
            if (parseFloat(distance) > 85) {
                let cents = 0;
                let pricePerKms = 0;
                if (liters == 20000) {
                    cents = 0.86;
                }
                if (liters == 31000) {
                    cents = 0.59;
                }
                if (liters == 62000) {
                    cents = 0.6;
                }
                pricePerKms = (cents * distance) / 281;
                monto = pricePerKms * liters
                console.log(pricePerKms);
                writeValues(monto, pricePerKms, distance);
            } else {
                if (liters == 20000) {
                    calculePrice(pipa, distance, liters)
                }
                if (liters == 31000) {
                    calculePrice(sencillo, distance, liters)
                }
                if (liters == 62000) {
                    calculePrice(full, distance, liters)
                }
            }
        }

        function calculePrice(truck, distance, liters) {
            let pricePerKms = 0;
            let range = 0;
            let monto = 0
            truck.forEach(price => {
                if (price.kms <= distance) {
                    pricePerKms = price.price
                    range = price.kms;
                }
            });
            if (pricePerKms != 0) {
                monto = distance * pricePerKms;
                writeValues(monto, (monto / liters), distance);
            } else {
                let lastPrice = truck[truck.length - 1].price;
                monto = distance * lastPrice;
                writeValues(monto, (monto / liters), distance);
            }
        }

        function writeValues(monto, pricePerKms, distance) {
            document.getElementById("costo-envio").value = monto != 0 ?
                '$ ' + pricePerKms.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') :
                'Ubicación fuera de los límites';

            document.getElementById("distancia-recorrer").value = monto != 0 ?
                distance + ' kms' : 'Ubicación fuera de los límites';

            document.getElementById("monto-total").value = monto != 0 ?
                '$ ' + monto.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') +
                " (Precio sin IVA)" : 'Ubicación fuera de los límites';
        }
    </script>
@endpush
