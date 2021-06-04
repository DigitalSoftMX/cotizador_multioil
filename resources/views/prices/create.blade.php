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
        let register = document.getElementById('register');
        let update = document.getElementById('update');
        $(document).ready(function() {
            init_calendar('calendar_first', `01-01-${date.getFullYear()}`, `12-31-${date.getFullYear()}`);
            update.classList.remove('btn-primary');
            update.disabled = true;
            messageRadio('Registrar');
        });

        $("#calendar_first").blur(function() {
            fecha = $('#calendar_first').val();
            company_id = $('#input-company_id').val();
            terminal_id = $('#input-terminal_id').val();
            if (company_id !== '' && terminal_id !== '') {
                getPrice(terminal_id, company_id, fecha);
            }
        });

        async function getPrice(terminal_id, company_id, fecha) {
            let id = 0;
            const query = await fetch(`/getprice/${terminal_id}/${company_id}/${fecha}`);
            const response = await query.json();
            if (response.response) {
                $("#regular").val(response.regular);
                $("#premium").val(response.premium);
                $("#diesel").val(response.diesel);
                id = response.id;
                messageRadio('Actualizar')
                update.classList.add('btn-primary');
                update.disabled = false;
                register.classList.remove('btn-primary');
                register.disabled = true;
                $('#store_update').attr('action', '{{ url('') }}/prices/' + id);
                document.getElementById('_method').value = 'put';
            } else {
                register.classList.add('btn-primary');
                register.disabled = false;
                update.classList.remove('btn-primary');
                update.disabled = true;
                messageRadio('Registrar')
                $('#store_update').attr('action', '{{ url('') }}/prices');
                document.getElementById('_method').value = 'post';
            }
        }

        function messageRadio(message) {
            let radio = document.getElementById('radiocontinue');
            radio.innerHTML='';
            radio.innerHTML=/* html */`
            <div class="form-check-radio">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="continue" value="1">
                        ${ message } e ir al listado de precios
                </label>
            </div>
            <div class="form-check-radio">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="continue" value="0">
                    ${ message } y volver
                </label>
            </div>`
        }

    </script>
@endpush
