<div class="modal fade bd-example-modal-lg-{{ $type }}" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post"
                action="{{ isset($payment) ? route('payments.update', [$invoice, $payment]) : route('payments.store', $invoice) }}"
                autocomplete="off" class="form-horizontal">
                @isset($payment)
                    @method('put')
                @endisset
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
                    <div class="row justify-content-center">
                        <div
                            class="form-group{{ $errors->has('payment_guerrera') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                            <label for="payment_guerrera">{{ __('Pago Cliente - Guerrera') }}</label>
                            <input type="number"
                                class="form-control{{ $errors->has('payment_guerrera') ? ' is-invalid' : '' }}"
                                id="input-payment_guerrera" aria-describedby="payment_guerreraHelp"
                                placeholder="Escribe la cantidad del pago"
                                value="{{ old('payment_guerrera', $payment->payment_guerrera ?? '') }}"
                                aria-required="true" name="payment_guerrera" step="any">
                            @if ($errors->has('payment_guerrera'))
                                <span id="payment_guerrera-error" class="error text-danger"
                                    for="input-payment_guerrera">
                                    {{ $errors->first('payment_guerrera') }}
                                </span>
                            @endif
                        </div>
                        <div
                            class="form-group{{ $errors->has('payment_g_valero') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                            <label for="payment_g_valero">{{ __('Pago Cliente - Guerrera - Valero') }}</label>
                            <input type="number"
                                class="form-control{{ $errors->has('payment_g_valero') ? ' is-invalid' : '' }}"
                                id="input-payment_g_valero" aria-describedby="payment_g_valeroHelp"
                                placeholder="Escribe la cantidad del pago"
                                value="{{ old('payment_g_valero', $payment->payment_g_valero ?? '') }}"
                                aria-required="true" name="payment_g_valero" step="any">
                            @if ($errors->has('payment_g_valero'))
                                <span id="payment_g_valero-error" class="error text-danger"
                                    for="input-payment_g_valero">
                                    {{ $errors->first('payment_g_valero') }}
                                </span>
                            @endif
                        </div>
                        <div
                            class="form-group{{ $errors->has('payment_freight') ? ' has-danger' : '' }} col-md-4 col-sm-12">
                            <label for="payment_freight">{{ __('Pago Fletera') }}</label>
                            <input type="number"
                                class="form-control{{ $errors->has('payment_freight') ? ' is-invalid' : '' }}"
                                id="input-payment_freight" aria-describedby="payment_freightHelp"
                                placeholder="Escribe la cantidad del pago"
                                value="{{ old('payment_freight', $payment->payment_freight ?? '') }}"
                                aria-required="true" name="payment_freight" step="any">
                            @if ($errors->has('payment_freight'))
                                <span id="payment_freight-error" class="error text-danger" for="input-payment_freight">
                                    {{ $errors->first('payment_freight') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit"
                        class="btn btn-primary">{{ isset($payment) ? 'Actualizar' : __('Registrar') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
