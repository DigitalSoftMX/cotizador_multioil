@extends('layouts.app', ['activePage' => 'Captura de precios',
'titlePage' => __('Captura de Precios de la competencia')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('prices.update', $price) }}" autocomplete="off" class="form-horizontal"
                        method="post">
                        @method('put')
                        @include('partials._prices',[$title='Actualizar precio de competencia'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
