@extends('layouts.app', ['activePage' => 'Captura de precios',
'titlePage' => __('Captura de Precios de la competencia')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">{{ __('Precios de la competencia') }}</h4>
                            <p class="card-category">{{ __('Aquí puedes gestionar los precios de la competencia.') }}</p>
                        </div>
                        <div class="card-body">
                            @include('partials._notification')
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a class="btn btn-sm btn-primary" href="{{ route('prices.create') }}">
                                        {{ __('Agregar Precio') }}
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
                            </div>
                            <div class="material-datatables">
                                <table cellspacing="0" class="table table-striped table-no-bordered table-hover"
                                    id="datatables" style="width:100%" width="100%">
                                    <thead class="text-primary">
                                        <th>{{ __('Competencia') }}</th>
                                        <th>{{ __('Terminal') }}</th>
                                        <th>{{ __('Precio Regular') }}</th>
                                        <th>{{ __('Precio Premium') }}</th>
                                        <th>{{ __('Precio Diésel') }}</th>
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
        $(document).ready(function() {
            loadTable('datatables');
            getPrices(0);
        });

        $(".selectpicker").change(function() {
            let company_id = document.getElementById('input-company_id').value;
        });
        $('#input-company_id').change(function() {
            let company_id = document.getElementById('input-company_id').value;
            getPrices(company_id);
        });

        async function getPrices(company_id) {
            try {
                const data = await fetch(`prices/${company_id}`);
                response = await data.json();
                console.log(response);
                destruir_table("datatables");
                $('#datatables').find('tbody').empty();
                response.prices.forEach(price => {
                    $("#datatables").find('tbody').append(/* html */
                        `<tr>
                            <td> ${price.company} </td>
                            <td> ${price.terminal} </td>
                            <td> ${price.regular} </td>
                            <td> ${price.premium} </td>
                            <td> ${price.diesel} </td>
                            <td> ${price.created_at} </td>
                            <td class="td-actions text-right">
                                <a rel="tooltip" class="btn btn-success btn-link"
                                    href="{{ url('') }}/prices/${price.id}/edit" data-original-title="" title="">
                                    <i class="material-icons">edit</i>
                                    <div class="ripple-container"></div>
                                </a>
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
