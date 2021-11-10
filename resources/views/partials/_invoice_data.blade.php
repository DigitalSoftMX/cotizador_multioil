<div class="card ">
    <div class="card-header">
        <h4 class="card-title"><strong>{{ __('Facturación Valero - Guerrera') }}</strong></h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 text-right">
                @if ($invoice->invoicepdf != null)
                    <a href="{{ route('download', [$invoice, 'invoicepdf', 'pdf']) }}"
                        class="btn btn-sm btn-success">{{ __('Descargar pdf') }}</a>
                @endif
                @if ($invoice->invoicexml != null)
                    <a href="{{ route('download', [$invoice, 'invoicexml', 'xml']) }}"
                        class="btn btn-sm btn-success">{{ __('Descargar xml') }}</a>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('invoicepayment') ? ' has-danger' : '' }} col-md-6 col-sm-12">
                <label for="invoicepayment">{{ __('Cantidad Facturada') }}</label>
                <input type="number" class="form-control{{ $errors->has('invoicepayment') ? ' is-invalid' : '' }}"
                    id="input-invoicepayment" aria-describedby="invoicepaymentHelp"
                    placeholder="Escribe el precio de compra por litro"
                    value="{{ old('invoicepayment', $invoice->invoicepayment) }}" aria-required="true"
                    name="invoicepayment" step="any" readonly>
                @if ($errors->has('invoicepayment'))
                    <span id="invoicepayment-error" class="error text-danger" for="input-invoicepayment">
                        {{ $errors->first('invoicepayment') }}
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('invoicecfdi') ? ' has-danger' : '' }} col-md-6 col-sm-12">
                <label for="invoicecfdi">{{ __('Factura') }}</label>
                <input type="text" class="form-control{{ $errors->has('invoicecfdi') ? ' is-invalid' : '' }}"
                    id="input-invoicecfdi" aria-describedby="invoicecfdiHelp" placeholder="Escribe la factura"
                    value="{{ old('invoicecfdi', $invoice->invoicecfdi) }}" aria-required="true" name="invoicecfdi"
                    step="any" @if ($rol != 1) readonly @endif>
                @if ($errors->has('invoicecfdi'))
                    <span id="invoicecfdi-error" class="error text-danger" for="input-invoicecfdi">
                        {{ $errors->first('invoicecfdi') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="form-group{{ $errors->has('paymentfolio') ? ' has-danger' : '' }} col-12">
                <label for="paymentfolio">{{ __('Folio') }}</label>
                <input type="text" class="form-control{{ $errors->has('paymentfolio') ? ' is-invalid' : '' }}"
                    id="input-paymentfolio" aria-describedby="paymentfolioHelp" placeholder="Folio de la factura"
                    value="{{ old('paymentfolio', $invoice->paymentfolio) }}" aria-required="true" name="paymentfolio"
                    readonly>
                @if ($errors->has('paymentfolio'))
                    <span id="paymentfolio-error" class="error text-danger" for="input-paymentfolio">
                        {{ $errors->first('paymentfolio') }}
                    </span>
                @endif
            </div>
        </div>
        @if ($rol == 1)
            <div class="row justify-content-center">
                <div class="col-md-6 col-sm-12">
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <label>{{ __('Factura PDF') }}</label>
                        <div class="justify-content-center">
                            <span class="btn btn-rose btn-sm btn-file">
                                <span class="fileinput-new">
                                    @if ($invoice->pdf ?? false)
                                        {{ __('Cambiar archivo') }}
                                    @else
                                        {{ __('Agregar archivo') }}
                                    @endif
                                </span>
                                <span class="fileinput-exists">Cambiar archivo</span>
                                <input type="file" name="file_invoicepdf" accept=".pdf">
                            </span>
                        </div>
                        @if ($errors->has('file_invoicepdf'))
                            <span id="text-file_invoicepdf" class="error text-danger" for="input-file_invoicepdf">
                                <br> {{ $errors->first('file_invoicepdf') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <label>{{ __('Factura XML') }}</label>
                        <div class="justify-content-center">
                            <span class="btn btn-rose btn-sm btn-file">
                                <span class="fileinput-new">
                                    @if ($invoice->pdf ?? false)
                                        {{ __('Cambiar archivo') }}
                                    @else
                                        {{ __('Agregar archivo') }}
                                    @endif
                                </span>
                                <span class="fileinput-exists">Cambiar archivo</span>
                                <input type="file" name="file_invoicexml" accept=".xml">
                            </span>
                        </div>
                        @if ($errors->has('file_invoicexml'))
                            <span id="text-file_invoicexml" class="error text-danger" for="input-file_invoicexml">
                                <br> {{ $errors->first('file_invoicexml') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer justify-content-center">
                <button type="submit" class="btn btn-primary">{{ __('Actualizar Factura Valero - Guerrera') }}
                </button>
            </div>
        @endif
    </div>
</div>
