@if (($rol = auth()->user()->roles->first()->id) == 1)
    <form method="post" action="{{ route('invoice', $invoice) }}" autocomplete="off" class="form-horizontal"
        enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><strong>{{ __('Facturación Valero - Guerrera') }}</strong></h4>
            </div>
            <div class="card-body">
                <hr>
                <label>{{ __('Datos de la factura 1') }}</label>
                <div class="row">
                    <div class="col-12 text-right">
                        @if ($invoice->invoicepdf)
                            <a href="{{ route('download', [$invoice, 'invoicepdf', 'pdf']) }}"
                                class="btn btn-sm btn-success">{{ __('Descargar pdf') }}</a>
                        @endif
                        @if ($invoice->invoicexml)
                            <a href="{{ route('download', [$invoice, 'invoicexml', 'xml']) }}"
                                class="btn btn-sm btn-success">{{ __('Descargar xml') }}</a>
                        @endif
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div
                        class="form-group{{ $errors->has('invoicepayment') ? ' has-danger' : '' }} col-md-6 col-sm-12">
                        <label for="invoicepayment">{{ __('Cantidad Facturada') }}</label>
                        <input type="number"
                            class="form-control{{ $errors->has('invoicepayment') ? ' is-invalid' : '' }}"
                            id="input-invoicepayment" aria-describedby="invoicepaymentHelp"
                            placeholder="Precio de compra por litro" name="invoicepayment"
                            value="{{ old('invoicepayment', $invoice->invoicepayment) }}" step="any">
                        @include('partials.errorsession',[$field='invoicepayment'])
                    </div>
                    <div class="form-group{{ $errors->has('invoicecfdi') ? ' has-danger' : '' }} col-md-6 col-sm-12">
                        <label for="invoicecfdi">{{ __('Factura') }}</label>
                        <input type="text" class="form-control{{ $errors->has('invoicecfdi') ? ' is-invalid' : '' }}"
                            id="input-invoicecfdi" aria-describedby="invoicecfdiHelp" placeholder="Escribe la factura"
                            value="{{ old('invoicecfdi', $invoice->invoicecfdi) }}" aria-required="true"
                            name="invoicecfdi" step="any" @if ($rol != 1) readonly @endif>
                        @include('partials.errorsession',[$field='invoicecfdi'])
                    </div>
                </div>
                <div class="row">
                    <div class="form-group{{ $errors->has('paymentfolio') ? ' has-danger' : '' }} col-12">
                        <label for="paymentfolio">{{ __('Folio') }}</label>
                        <input type="text" class="form-control" id="input-paymentfolio"
                            aria-describedby="paymentfolioHelp" placeholder="Folio de la factura"
                            value="{{ old('paymentfolio', $invoice->paymentfolio) }}" readonly>
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
                                            @if ($invoice->file_invoicepdf ?? false)
                                                {{ __('Cambiar archivo') }}
                                            @else
                                                {{ __('Agregar archivo') }}
                                            @endif
                                        </span>
                                        <span class="fileinput-exists">Cambiar archivo</span>
                                        <input type="file" name="file_invoicepdf" accept=".pdf">
                                    </span>
                                </div>
                                @include('partials.errorsession',[$field='file_invoicepdf'])
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                <label>{{ __('Factura XML') }}</label>
                                <div class="justify-content-center">
                                    <span class="btn btn-rose btn-sm btn-file">
                                        <span class="fileinput-new">
                                            @if ($invoice->file_invoicexml ?? false)
                                                {{ __('Cambiar archivo') }}
                                            @else
                                                {{ __('Agregar archivo') }}
                                            @endif
                                        </span>
                                        <span class="fileinput-exists">Cambiar archivo</span>
                                        <input type="file" name="file_invoicexml" accept=".xml">
                                    </span>
                                </div>
                                @include('partials.errorsession',[$field='file_invoicexml'])
                            </div>
                        </div>
                    </div>
                @endif
                <hr>
                <label>{{ __('Datos de la factura 2') }}</label>
                <div class="row">
                    <div class="col-12 text-right">
                        @if ($invoice->invoicepdf2)
                            <a href="{{ route('download', [$invoice, 'invoicepdf2', 'pdf']) }}"
                                class="btn btn-sm btn-success">{{ __('Descargar pdf') }}</a>
                        @endif
                        @if ($invoice->invoicexml2)
                            <a href="{{ route('download', [$invoice, 'invoicexml2', 'xml']) }}"
                                class="btn btn-sm btn-success">{{ __('Descargar xml') }}</a>
                        @endif
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div
                        class="form-group{{ $errors->has('invoicepayment2') ? ' has-danger' : '' }} col-md-6 col-sm-12">
                        <label for="invoicepayment2">{{ __('Cantidad Facturada') }}</label>
                        <input type="number"
                            class="form-control{{ $errors->has('invoicepayment2') ? ' is-invalid' : '' }}"
                            id="input-invoicepayment2" aria-describedby="invoicepayment2Help"
                            placeholder="Precio de compra por litro" name="invoicepayment2"
                            value="{{ old('invoicepayment2', $invoice->invoicepayment2) }}" step="any">
                        @include('partials.errorsession',[$field='invoicepayment2'])
                    </div>
                    <div
                        class="form-group{{ $errors->has('invoicecfdi2') ? ' has-danger' : '' }} col-md-6 col-sm-12">
                        <label for="invoicecfdi2">{{ __('Factura') }}</label>
                        <input type="text"
                            class="form-control{{ $errors->has('invoicecfdi2') ? ' is-invalid' : '' }}"
                            id="input-invoicecfdi2" aria-describedby="invoicecfdi2Help" placeholder="Escribe la factura"
                            value="{{ old('invoicecfdi2', $invoice->invoicecfdi2) }}" aria-required="true"
                            name="invoicecfdi2" step="any" @if ($rol != 1) readonly @endif>
                        @include('partials.errorsession',[$field='invoicecfdi2'])
                    </div>
                </div>
                <div class="row">
                    <div class="form-group{{ $errors->has('paymentfolio2') ? ' has-danger' : '' }} col-12">
                        <label for="paymentfolio2">{{ __('Folio') }}</label>
                        <input type="text" class="form-control" id="input-paymentfolio2"
                            aria-describedby="paymentfolio2Help" placeholder="Folio de la factura"
                            value="{{ old('paymentfolio2', $invoice->paymentfolio2) }}" readonly>
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
                                            @if ($invoice->file_invoicepdf2 ?? false)
                                                {{ __('Cambiar archivo') }}
                                            @else
                                                {{ __('Agregar archivo') }}
                                            @endif
                                        </span>
                                        <span class="fileinput-exists">Cambiar archivo</span>
                                        <input type="file" name="file_invoicepdf2" accept=".pdf">
                                    </span>
                                </div>
                                @include('partials.errorsession',[$field='file_invoicepdf2'])
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                <label>{{ __('Factura XML') }}</label>
                                <div class="justify-content-center">
                                    <span class="btn btn-rose btn-sm btn-file">
                                        <span class="fileinput-new">
                                            @if ($invoice->file_invoicexml2 ?? false)
                                                {{ __('Cambiar archivo') }}
                                            @else
                                                {{ __('Agregar archivo') }}
                                            @endif
                                        </span>
                                        <span class="fileinput-exists">Cambiar archivo</span>
                                        <input type="file" name="file_invoicexml2" accept=".xml">
                                    </span>
                                </div>
                                @include('partials.errorsession',[$field='file_invoicexml2'])
                            </div>
                        </div>
                    </div>
                @endif
                @if ($rol == 1)
                    <div class="card-footer justify-content-center">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Actualizar Factura Valero - Guerrera') }}
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </form>
@endif
