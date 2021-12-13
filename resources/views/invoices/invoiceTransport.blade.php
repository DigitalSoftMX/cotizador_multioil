@if (($rol = auth()->user()->roles->first()->id) == 1)
    <form id="transportistaForm" action="{{ route('shipper', $invoice) }}" method="post" autocomplete="off"
        class="form-horizontal" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <strong>{{ __('Facturación Transporte') }}</strong>
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 text-right">
                        @if ($invoice->shipperpdf)
                            <a href="{{ route('download', [$invoice, 'shipperpdf', 'pdf']) }}"
                                class="btn btn-sm btn-success">{{ __('Descargar pdf') }}</a>
                        @endif
                        @if ($invoice->shipperxml)
                            <a href="{{ route('download', [$invoice, 'shipperxml', 'xml']) }}"
                                class="btn btn-sm btn-success">{{ __('Descargar xml') }}</a>
                        @endif
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="shipper">{{ __('Transportista') }}</label>
                        <input type="text" class="form-control" id="input-shipper" aria-describedby="shipperHelp"
                            placeholder="Escribe el nombre del transportista"
                            value="{{ old('shipper', $invoice->shipper) }}" readonly>
                    </div>
                    <div
                        class="form-group{{ $errors->has('number_shipper') ? ' has-danger' : '' }} col-md-6 col-sm-12">
                        <label for="number_shipper">{{ __('Número de factura') }}</label>
                        <input type="text"
                            class="form-control{{ $errors->has('number_shipper') ? ' is-invalid' : '' }}"
                            id="input-number_shipper" aria-describedby="number_shipperHelp"
                            placeholder="Escribe el número de factura"
                            value="{{ old('number_shipper', $invoice->number_shipper) }}" aria-required="true"
                            name="number_shipper" step="any" @if ($rol != 1) readonly @endif>
                        @include('partials.errorsession',[$field='number_shipper'])
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="invoice_shipper">{{ __('Cantidad Facturada') }}</label>
                        <input type="number" class="form-control" id="input-invoice_shipper"
                            aria-describedby="invoice_shipperHelp" placeholder="Escribe la cantidad facturada"
                            value="{{ old('invoice_shipper', $invoice->invoice_shipper) }}" step="any" readonly>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="shipperfolio">{{ __('Folio') }}</label>
                        <textarea class="form-control" id="input-shipperfolio" aria-describedby="shipperfolioHelp"
                            placeholder="Folio" rows="2"
                            readonly>{{ old('shipperfolio', $invoice->shipperfolio) }}</textarea>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            <label>{{ __('Factura PDF') }}</label>
                            <div class="justify-content-center">
                                <span class="btn btn-rose btn-sm btn-file">
                                    <span class="fileinput-new">
                                        @if ($invoice->shipperpdf ?? false)
                                            {{ __('Cambiar archivo') }}
                                        @else
                                            {{ __('Agregar archivo') }}
                                        @endif
                                    </span>
                                    <span class="fileinput-exists">Cambiar
                                        archivo</span>
                                    <input type="file" name="file_shipperpdf" accept=".pdf">
                                </span>
                            </div>
                            @include('partials.errorsession',[$field='file_shipperpdf'])
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            <label>{{ __('Factura XML') }}</label>
                            <div class="justify-content-center">
                                <span class="btn btn-rose btn-sm btn-file">
                                    <span class="fileinput-new">
                                        @if ($invoice->shipperxml ?? false)
                                            {{ __('Cambiar archivo') }}
                                        @else
                                            {{ __('Agregar archivo') }}
                                        @endif
                                    </span>
                                    <span class="fileinput-exists">Cambiar
                                        archivo</span>
                                    <input type="file" name="file_shipperxml" accept=".xml">
                                </span>
                            </div>
                            @include('partials.errorsession',[$field='file_shipperxml'])
                        </div>
                    </div>
                </div>
                @if ($rol == 1)
                    <div class="card-footer justify-content-center">
                        <button type="button" id="transportistaButton"
                            onclick="disabledButton('transportistaButton','transportistaForm')"
                            class="btn btn-primary">{{ __('Actualizar Facturación Transporte') }}
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </form>
@endif
