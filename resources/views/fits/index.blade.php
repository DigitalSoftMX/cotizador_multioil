@extends('layouts.app', ['activePage' => 'Fee', 'titlePage' => __('Fee')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Fee') }}</h4>
                            <p class="card-category">
                                {{ __('Aquí puedes administrar todos los Fee de las terminales.') }}
                            </p>
                        </div>
                        <div class="card-body">
                            @include('partials._notification')
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a class="btn btn-sm btn-primary"
                                        href="{{ route('fits.create') }}">{{ __('Agregar Fee') }}
                                    </a>
                                </div>
                            </div>
                            <div class="row justify-content-md-start">
                                <div class="form-group{{ $errors->has('company_id') ? ' has-danger' : '' }} col-sm-3">
                                    <select id="input-company_id" name="company_id"
                                        class="selectpicker show-menu-arrow {{ $errors->has('company_id') ? ' has-danger' : '' }}"
                                        data-style="btn-primary" data-width="100%" data-live-search="true">
                                        <option value="0" selected>{{ __('Todas las empresas') }}</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('company_id'))
                                        <span id="name-company_id" class="error text-danger"
                                            for="input-company_id">{{ $errors->first('company_id') }}</span>
                                    @endif
                                </div>
                                {{-- <div class="col-3">
                                    <label class="label-control">{{ __('Fecha') }}</label>
                                    <input class="form-control datetimepicker" id="calendar_first" name="date" type="text"
                                        value="" />
                                </div> --}}
                            </div>
                            <div class="material-datatables">
                                <table cellspacing="0" class="table table-striped table-no-bordered table-hover"
                                    id="datatables" style="width:100%" width="100%">
                                    <thead class="text-primary">
                                        <th>{{ __('Empresa') }}</th>
                                        <th>{{ __('Terminal') }}</th>
                                        <th>{{ __('Precio base') }}</th>
                                        <th>{{ __('Regular Fee') }}</th>
                                        <th>{{ __('Premium Fee') }}</th>
                                        <th>{{ __('Diesel Fee') }}</th>
                                        <th>{{ __('Fecha de Alta') }}</th>
                                        <th>{{ __('Acciones') }}</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/ventas.js') }}"></script>
    <script>
        let date = new Date();
        $(document).ready(function() {
            loadTable('datatables');
            init_calendar('calendar_first', `01-01-${date.getFullYear()}`, `12-31-${date.getFullYear()}`);
            getFees(0);
        });

        $(".selectpicker").change(function() {
            let company_id = document.getElementById('input-company_id').value;
        });
        $('#input-company_id').change(function() {
            let company_id = document.getElementById('input-company_id').value;
            /* let fecha = $('#calendar_first').val();
            console.log(fecha); */
            getFees(company_id);
        });

        /* $("#calendar_first").blur(function() {
            let fecha = $('#calendar_first').val();
            console.log(fecha);
        }); */

        async function getFees(company_id) {
            try {
                console.log(`{{ url('') }}/companies/${company_id}`);
                const data = await fetch(`{{ url('') }}/companies/${company_id}`);
                response = await data.json();
                destruir_table("datatables");
                $('#datatables').find('tbody').empty();
                response.fees.forEach(fee => {
                    $("#datatables").find('tbody').append( /* html */
                        `<tr>
                            <td> ${fee.company} </td>
                            <td> ${fee.terminal} </td>
                            <td> ${fee.base} </td>
                            <td> ${fee.regular_fit} </td>
                            <td> ${fee.premium_fit} </td>
                            <td> ${fee.diesel_fit} </td>
                            <td> ${fee.created_at} </td>
                            <td class="td-actions">
                                <form action="{{ url('') }}/fits/${fee.id}" method="post">
                                    @csrf
                                    @method('delete')
                                    <div class="row justify-content-end">
                                        <a rel="tooltip" class="btn btn-success btn-link"
                                            href="{{ url('') }}/fits/${fee.id}/edit" data-original-title="" title="">
                                            <i class="material-icons">edit</i>
                                            <div class="ripple-container"></div>
                                        </a>
                                        <button type="submit" class="btn btn-danger btn-link"
                                            data-original-title="" title=""
                                            onclick="confirm('{{ __('¿Estás seguro de que deseas eliminar a este fee?') }}') ? this.parentElement.submit() : ''">
                                            <i class="material-icons">close</i>
                                            <div class="ripple-container"></div>
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>`
                    );
                });
                loadTable('datatables');
            } catch (error) {
                console.log(error)
            }
        };
    </script>
@endpush
