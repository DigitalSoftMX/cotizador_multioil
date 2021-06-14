@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="container-fluid mt-3">
            <div class="row">

                <div class="card card-nav-tabs">
                    <div class="card-header card-header-primary">
                        <div class="row">
                            <div class="col mt-3"> Gráficas de competencias</div>
                            <div class="col">
                                <select class="selectpicker float-right" data-style="btn-primary" id="fecha">
                                    <option disabled selected>Elige un Mes</option>
                                    @foreach ( $meses_espaniol as $mes_espaniol)
                                        <option value="{{ $mes_espaniol['numerMonth'] }}">{{ $mes_espaniol['nameMonth'] }}</option>
                                    @endforeach

                                </select>
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

