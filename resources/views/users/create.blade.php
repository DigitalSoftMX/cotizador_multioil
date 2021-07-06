@extends('layouts.app', ['activePage' => 'Usuarios', 'titlePage' => __('Gestión de usuarios')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('users.store') }}" autocomplete="off" class="form-horizontal">
                        @method('post')
                        @include('partials._users')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection