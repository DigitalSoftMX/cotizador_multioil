@extends('layouts.app', ['activePage' => 'Terminales', 'titlePage' => __('Alta de Terminales')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 ">
                    <form method="post" action="{{ route('terminals.store') }}" autocomplete="off"
                        class="form-horizontal">
                        @method('post')
                        @include('partials._terminals')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
