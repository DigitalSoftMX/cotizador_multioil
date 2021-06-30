@extends('layouts.app', ['activePage' => 'Fee', 'titlePage' => __('Fee')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('fits.update', $fit) }}" autocomplete="off" class="form-horizontal"
                        method="post">
                        @method('put')
                        @include('partials._fees',[$title='Actualizar',$button='Actualizar'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
