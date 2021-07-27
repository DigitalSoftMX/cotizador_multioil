@extends('layouts.app', ['activePage' => $activePage, 'titlePage' => __('Estado de cuenta')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">
                                @if (auth()->user()->roles->first()->id == 1)
                                    <a href="{{ route('companies.index') }}" title="Volver a la página anterior">
                                        <span class="material-icons">arrow_back_ios</span>
                                    </a>
                                @endif
                                {{ __('Estado de cuenta') }}
                            </h4>
                            <p class="card-category">
                                {{ __('Aquí puedes ver el estado de cuenta de la empresa') }}
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <h4>
                                    {{ __('Comisionista: ') }}<strong>{{ "{$user->name} {$user->app_name} {$user->apm_name}" }}</strong>
                                </h4>
                            </div>
                            <div class="form-group{{ $errors->has('month_id') ? ' has-danger' : '' }} col-md-3 col-sm-12">
                                <label class="form-check-label">{{ __('Ventas del mes:') }}</label>
                                <select id="input-month_id" name="month_id"
                                    class="selectpicker show-menu-arrow {{ $errors->has('month_id') ? ' has-danger' : '' }} mt-1"
                                    data-style="btn-primary" data-width="100%" data-live-search="true">
                                    @foreach ($months as $month)
                                        @if (date('m') >= $month['id'])
                                            <option value="{{ $month['id'] }}" @if (date('m') == $month['id']) selected @endif>{{ $month['name'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('month_id'))
                                    <span id="name-month_id" class="error text-danger"
                                        for="input-month_id">{{ $errors->first('month_id') }}</span>
                                @endif
                            </div>
                            <div class="table-responsive">
                                <table id="datatables" class="table">
                                    <thead class=" text-primary text-center">
                                        <th>{{ __('Empresa') }}</th>
                                        <th>{{ __('Fecha de carga') }}</th>
                                        <th>{{ __('Factura') }}</th>
                                        <th>{{ __('Producto') }}</th>
                                        <th>{{ __('Litros') }}</th>
                                        <th>{{ __('Centavos por litro') }}</th>
                                        <th>{{ __('Comisión') }}</th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <div class="col-sm-12 text-right mt-3">
                                <h5>
                                    {{ __('Saldo total: ') }} <strong id="balance"></strong>
                                </h5>
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
        let month = "{{ date('m') }}";
        let user = "{{ $user->id }}";
        $(document).ready(function() {
            loadTable('datatables');
            getSales();
        });
        $(".selectpicker").change(function() {
            document.getElementById('input-month_id').value;
        });
        $('#input-month_id').change(function() {
            month = document.getElementById('input-month_id').value;
            getSales()
        });
        async function getSales() {
            try {
                const resp = await fetch(`{{ url('') }}/commission/${user}/${month}`);
                const data = await resp.json();
                console.log(data);
                destruir_table("datatables");
                $('#datatables').find('tbody').empty();
                data.sales.forEach(sale => {
                    $("#datatables").find('tbody').append( /* html */
                        `<tr class='text-center'>
                            <td> ${sale.company}</td>
                            <td> ${sale.date} </td>
                            <td> ${sale.cfdi} </td>
                            <td> ${sale.product} </td>
                            <td> ${sale.liters} </td>
                            <td> ${sale.centsPerLiter} </td>
                            <td> ${sale.commission} </td>
                        </tr>`
                    );
                });
                loadTable('datatables');
                document.getElementById("balance").innerText = data.total
            } catch (error) {
                console.log(error);
            }
        }
    </script>
@endpush
