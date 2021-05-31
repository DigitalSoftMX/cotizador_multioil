@extends('layouts.app', ['activePage' => 'Usuarios', 'titlePage' => __('Gestión de usuarios')])

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('users.update', $user) }}" autocomplete="off"
                        class="form-horizontal">
                        @method('put')
                        @include('partials._users',[$title='Editar usuario',$button='Actualizar'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
