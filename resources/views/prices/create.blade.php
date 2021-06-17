@extends('layouts.app', ['activePage' => 'Captura de precios',
'titlePage' => __('Captura de Precios de la competencia')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('prices.store') }}" autocomplete="off" class="form-horizontal" method="post"
                        id="store_update">
                        <input type="hidden" name="_method" value="post" id="_method">
                        @include('partials._prices')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        let date = new Date();
        $(document).ready(function() {
            init_calendar('calendar_first', `01-01-${date.getFullYear()}`, `12-31-${date.getFullYear()}`);
        });

    </script>
@endpush
