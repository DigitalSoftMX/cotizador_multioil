<div class="modal fade bd-example-modal-lg-{{ $type }}" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="formPagos"
                action="{{ isset($payment) ? route('payments.update', [$invoice, $payment]) : route('payments.store', $invoice) }}"
                autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                @isset($payment) @method('put') @endisset
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        <strong>{{ (isset($payment) ? 'Actualización' : 'Registro') . __(' de pago') }}</strong>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div
                            class="form-group{{ $errors->has('payment_guerrera') ? ' has-danger' : '' }} col-md-6 col-sm-12">
                            <label for="payment_guerrera">{{ __('Pago Cliente - Guerrera') }}</label>
                            <input type="number"
                                class="form-control{{ $errors->has('payment_guerrera') ? ' is-invalid' : '' }}"
                                id="input-payment_guerrera" aria-describedby="payment_guerreraHelp"
                                placeholder="Escribe la cantidad del pago"
                                value="{{ old('payment_guerrera', $payment->payment_guerrera ?? '') }}"
                                aria-required="true" name="payment_guerrera" step="any">
                            @include('partials.errorsession',[$field='payment_guerrera'])
                        </div>

                        <div
                            class="form-group{{ $errors->has('payment_g_valero') ? ' has-danger' : '' }} col-md-6 col-sm-12">
                            <label for="payment_g_valero">{{ __('Pago Cliente - Guerrera - Valero') }}</label>
                            <input type="number"
                                class="form-control{{ $errors->has('payment_g_valero') ? ' is-invalid' : '' }}"
                                id="input-payment_g_valero" aria-describedby="payment_g_valeroHelp"
                                placeholder="Escribe la cantidad del pago"
                                value="{{ old('payment_g_valero', $payment->payment_g_valero ?? '') }}"
                                aria-required="true" name="payment_g_valero" step="any">
                            @include('partials.errorsession',[$field='payment_g_valero'])
                        </div>
                    </div>
                    <div class="row">
                        <div
                            class="form-group{{ $errors->has('payment_freight') ? ' has-danger' : '' }} col-md-6 col-sm-12">
                            <label for="payment_freight">{{ __('Pago Fletera') }}</label>
                            <input type="number"
                                class="form-control{{ $errors->has('payment_freight') ? ' is-invalid' : '' }}"
                                id="input-payment_freight" aria-describedby="payment_freightHelp"
                                placeholder="Escribe la cantidad del pago"
                                value="{{ old('payment_freight', $payment->payment_freight ?? '') }}"
                                aria-required="true" name="payment_freight" step="any">
                            @include('partials.errorsession',[$field='payment_freight'])
                        </div>
                        <div
                            class="form-group{{ $errors->has('created_at') ? ' has-danger' : '' }} col-md-6 col-sm-12">
                            <label class="label-control">{{ __('Fecha') }}</label>
                            <input class="form-control datetimepicker" id="created_at-id{{ $payment->id ?? '' }}"
                                name="created_at" type="text"
                                value="{{ old('created_at', isset($payment) ? $payment->created_at->format('Y-m-d') : date('Y-m-d')) }}"
                                required />
                            @include('partials.errorsession',[$field='created_at'])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            @if ($payment->voucherguerrera ?? false)
                                <a class="btn btn-sm btn-success w-100"
                                    href="{{ route('downloadVoucher', [$payment, 'guerrera']) }}">
                                    {{ __('Descargar factura Guerrera') }}
                                </a>
                            @endif
                            <label>{{ __('Factura Cliente Guerrera') }}</label>
                            @include('invoices.inputFile',
                            [$file=$payment->voucherguerrera ??false, $name='file_voucherguerrera'])
                        </div>
                        <div class="col-sm-6">
                            @if ($payment->vouchervalero ?? false)
                                <a class="btn btn-sm btn-success"
                                    href="{{ route('downloadVoucher', [$payment, 'valero']) }}">
                                    {{ __('Descargar factura Guerrera - Valero') }}
                                </a>
                            @endif
                            <label>{{ __('Factura Guerrera - Valero') }}</label>
                            @include('invoices.inputFile',
                            [$file=$payment->vouchervalero ?? false, $name='file_vouchervalero'])
                        </div>
                    </div>
                    <div class="row justify-content-start">
                        <div class="col-sm-6">
                            @if ($payment->voucherfreight ?? false)
                                <a class="btn btn-sm btn-success w-100"
                                    href="{{ route('downloadVoucher', [$payment, 'fletera']) }}">
                                    {{ __('Descargar factura Fletera') }}
                                </a>
                            @endif
                            <label>{{ __('Factura Fletera') }}</label>
                            @include('invoices.inputFile',
                            [$file=$payment->voucherfreight ?? false, $name='file_voucherfreight'])
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="btn" id="btnPagos" onclick="disabledButton('btnPagos','formPagos')"
                        class="btn btn-primary">{{ isset($payment) ? 'Actualizar' : __('Registrar') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
