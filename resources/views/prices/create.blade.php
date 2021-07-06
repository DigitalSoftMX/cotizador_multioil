@extends('layouts.app', ['activePage' => 'Captura de precios',
'titlePage' => __('Captura de Precios de la competencia')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('prices.store') }}" autocomplete="off" class="form-horizontal" method="post"
                        id="store_update">
                        @include('partials._prices')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
