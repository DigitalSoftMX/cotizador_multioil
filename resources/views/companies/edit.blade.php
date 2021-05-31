@extends('layouts.app', ['activePage' => 'Empresas', 'titlePage' => __('Gestión de empresas')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('companies.update', $company) }}" autocomplete="off"
                        class="form-horizontal">
                        @method('patch')
                        @include('partials._companies',[$title='Editar empresa',$button='Actualizar'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
