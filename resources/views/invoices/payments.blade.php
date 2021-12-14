<div class="row justify-content-center">
    <div class="col-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><strong>{{ __('Pagos del pedido') }}</strong></h4>
            </div>
            <div class="card-body">
                @if (auth()->user()->roles->first()->id == 1)
                    <div class="row">
                        <div class="col-12 text-right">
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                data-target=".bd-example-modal-lg-register">{{ __('Agregar pago') }}</button>
                            @include('invoices.paymentmodal',[$type='register'])
                        </div>
                    </div>
                @endif
                <div class="table-responsive">
                    <table id="datatables" class="table">
                        <thead class=" text-primary">
                            <th>{{ __('Cliente La Guerrera') }}</th>
                            <th>{{ __('La Guerrera Valero') }}</th>
                            <th>{{ __('Fletera') }}</th>
                            <th>{{ __('Fecha') }}</th>
                            @if (auth()->user()->roles->first()->id == 1)
                                <th class="text-right">{{ __('Acciones') }}</th>
                            @endif
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ '$ ' . number_format($payment->payment_guerrera, 2) }}
                                    </td>
                                    <td>{{ '$ ' . number_format($payment->payment_g_valero, 2) }}
                                    </td>
                                    <td>{{ '$ ' . number_format($payment->payment_freight, 2) }}
                                    </td>
                                    <td>{{ $payment->created_at->format('Y/m/d') }}</td>
                                    @if (auth()->user()->roles->first()->id == 1)
                                        <td class="td-actions text-right">
                                            <button type="button" class="btn btn-success btn-link" data-toggle="modal"
                                                data-target=".bd-example-modal-lg-payment{{ $payment->id }}">
                                                <i class="material-icons">edit</i>
                                                <div class="ripple-container"></div>
                                            </button>
                                            @include('invoices.paymentmodal',[$type="payment$payment->id"])
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
