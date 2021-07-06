@extends('layouts.app', ['activePage' => 'Fee', 'titlePage' => __('Fee')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('fits.store') }}" autocomplete="off" class="form-horizontal" method="post">
                        @include('partials._fees')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
