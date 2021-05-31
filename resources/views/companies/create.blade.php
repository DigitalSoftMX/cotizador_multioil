@extends('layouts.app', ['activePage' => 'Empresas', 'titlePage' => __('Gestión de empresas')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('companies.store') }}" autocomplete="off"
                        class="form-horizontal">
                        @include('partials._companies')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
