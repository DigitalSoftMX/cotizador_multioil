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
@push('js')
    <script>
        let date = new Date();
        let id = "{{ $price->id }}";
        let update = document.getElementById('update');

        $(document).ready(function() {
            init_calendar('calendar_first', `01-01-${date.getFullYear()}`, `12-31-${date.getFullYear()}`);
            $('#calendar_first').val("{{ $price->created_at->format('Y-m-d') }}");
        });

        $("#calendar_first").blur(function() {
            fecha = $('#calendar_first').val();
            company_id = $('#input-company_id').val();
            terminal_id = $('#input-terminal_id').val();
            if (company_id !== '' && terminal_id !== '') {
                getPrice(terminal_id, company_id, fecha);
            }
        });

        update.onclick = () => {
            if (id != "{{ $price->id }}") {
                if (confirm(
                        'Atención. Ya existe un precio registrado. ¿Esta seguro de actualizarlo con los nuevos datos?'))
                    return true;
                return false
            }
        }

        async function getPrice(terminal_id, company_id, fecha) {
            const query = await fetch(`/getprice/${terminal_id}/${company_id}/${fecha}`);
            const response = await query.json();
            if (response.response) {
                if (response.id != "{{ $price->id }}") {
                    console.log(response);
                    id = response.id;
                    $.notify({
                        icon: 'warning',
                        message: '<strong>Atención.</strong> Ya existe precio registrado con la fecha y competencia.'
                    }, {
                        type: 'danger',
                        timer: 3000,
                        placement: {
                            from: 'top',
                            align: 'center'
                        }
                    });
                }
            }
        }

    </script>
@endpush
