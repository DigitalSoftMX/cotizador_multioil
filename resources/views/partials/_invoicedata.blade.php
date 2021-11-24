<div class="card ">
    <div class="card-header">
        <h4 class="card-title"><strong>{{ __('Datos de facturación') }}</strong></h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 text-right">
                @if ($invoice->pdf)
                    <a href="{{ route('download', [$invoice, 'pdf', 'pdf']) }}"
                        class="btn btn-sm btn-success">{{ __('Descargar pdf') }}</a>
                @endif
                @if ($invoice->xml)
                    <a href="{{ route('download', [$invoice, 'xml', 'xml']) }}"
                        class="btn btn-sm btn-success">{{ __('Descargar xml') }}</a>
                @endif
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="form-group{{ $errors->has('dispatched') ? ' has-danger' : '' }} col-12">
                <label class="label-control">{{ __('Fecha de despacho') }}</label>
                <input class="form-control datetimepicker" id="calendar_first" name="dispatched" type="text"
                    value="{{ old('dispatched', $invoice->dispatched) }}" @if ($rol != 1) readonly @endif />
                @if ($errors->has('dispatched'))
                    <span id="dispatched-error" class="error text-danger" for="input-dispatched">
                        {{ $errors->first('dispatched') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }} col-12">
                <label for="price">{{ __('Precio de compra') }}</label>
                <input type="number" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}"
                    id="input-price" aria-describedby="priceHelp" placeholder="Escribe el precio de compra por litro"
                    value="{{ old('price', $invoice->price) }}" name="price" step="any" @if ($rol != 1) readonly @endif>
                @if ($errors->has('price'))
                    <span id="price-error" class="error text-danger" for="input-price">
                        {{ $errors->first('price') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('sale_price') ? ' has-danger' : '' }} col-12">
                <label for="sale_price">{{ __('Precio de venta') }}</label>
                <input type="number" class="form-control{{ $errors->has('sale_price') ? ' is-invalid' : '' }}"
                    id="input-sale_price" aria-describedby="sale_priceHelp"
                    placeholder="Escribe el precio de venta por litro"
                    value="{{ old('sale_price', $invoice->sale_price) }}" name="sale_price" step="any"
                    @if ($rol != 1) readonly @endif>
                @if ($errors->has('sale_price'))
                    <span id="sale_price-error" class="error text-danger" for="input-sale_price">
                        {{ $errors->first('sale_price') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('bol_load') ? ' has-danger' : '' }} col-12">
                <label for="bol_load">{{ __('Folio Bol de carga') }}</label>
                <input type="number" class="form-control{{ $errors->has('bol_load') ? ' is-invalid' : '' }}"
                    id="input-bol_load" aria-describedby="bol_loadHelp" placeholder="Escribe el folio bol de carga"
                    value="{{ old('bol_load', $invoice->bol_load) }}" name="bol_load" step="any"
                    @if ($rol != 1) readonly @endif>
                @if ($errors->has('bol_load'))
                    <span id="bol_load-error" class="error text-danger" for="input-bol_load">
                        {{ $errors->first('bol_load') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('dispatched_liters') ? ' has-danger' : '' }} col-12">
                <label for="dispatched_liters">{{ __('Litros despachados') }}</label>
                <input type="number" class="form-control{{ $errors->has('dispatched_liters') ? ' is-invalid' : '' }}"
                    id="input-dispatched_liters" aria-describedby="dispatched_litersHelp"
                    placeholder="Escribe los litros despachados"
                    value="{{ old('dispatched_liters', $invoice->dispatched_liters) }}" name="dispatched_liters"
                    step="any" @if ($rol != 1) readonly @endif>
                @if ($errors->has('dispatched_liters'))
                    <span id="dispatched_liters-error" class="error text-danger" for="input-dispatched_liters">
                        {{ $errors->first('dispatched_liters') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('root_liters') ? ' has-danger' : '' }} col-12">
                <label for="root_liters">{{ __('Litros vendedor v-root') }}</label>
                <input type="number" class="form-control{{ $errors->has('root_liters') ? ' is-invalid' : '' }}"
                    id="input-root_liters" aria-describedby="root_litersHelp" placeholder="Escribe los litros root"
                    value="{{ old('root_liters', $invoice->root_liters) }}" name="root_liters" step="any"
                    @if ($rol != 1) readonly @endif>
                @if ($errors->has('root_liters'))
                    <span id="root_liters-error" class="error text-danger" for="input-root_liters">
                        {{ $errors->first('root_liters') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('invoice') ? ' has-danger' : '' }} col-12">
                <label for="invoice">{{ __('Cantidad facturada') }}</label>
                <input type="number" class="form-control{{ $errors->has('invoice') ? ' is-invalid' : '' }}"
                    id="input-invoice" aria-describedby="invoiceHelp" placeholder="Total cantidad facturada"
                    value="{{ old('invoice', $invoice->invoice) }}" name="invoice" step="any" {{-- @if ($rol != 1) readonly @endif> --}}
                    readonly>
                @if ($errors->has('invoice'))
                    <span id="invoice-error" class="error text-danger" for="input-invoice">
                        {{ $errors->first('invoice') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('invoicefolio') ? ' has-danger' : '' }} col-12">
                <label for="invoicefolio">{{ __('Folio') }}</label>
                {{-- name="invoicefolio" @if ($rol != 1) readonly @endif> --}}
                <textarea class="form-control{{ $errors->has('invoicefolio') ? ' is-invalid' : '' }}"
                    name="invoicefolio" id="input-invoicefolio" aria-describedby="invoicefolioHelp" placeholder="Folio"
                    rows="2" readonly>{{ old('invoicefolio', $invoice->invoicefolio) }}
                </textarea>
                @if ($errors->has('invoicefolio'))
                    <span id="invoicefolio-error" class="error text-danger" for="input-invoicefolio">
                        {{ $errors->first('invoicefolio') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('CFDI') ? ' has-danger' : '' }} col-12">
                <label for="CFDI">{{ __('Factura') }}</label>
                <input type="text" class="form-control{{ $errors->has('CFDI') ? ' is-invalid' : '' }}"
                    id="input-CFDI" aria-describedby="CFDIHelp" placeholder="Escribe la factura"
                    value="{{ old('CFDI', $invoice->CFDI) }}" name="CFDI" step="any" @if ($rol != 1) readonly @endif>
                @if ($errors->has('CFDI'))
                    <span id="CFDI-error" class="error text-danger" for="input-CFDI">
                        {{ $errors->first('CFDI') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('name_freight') ? ' has-danger' : '' }} col-12">
                <label for="name_freight">{{ __('Nombre de la fletera') }}</label>
                <input type="text" class="form-control{{ $errors->has('name_freight') ? ' is-invalid' : '' }}"
                    id="input-name_freight" aria-describedby="name_freightHelp"
                    placeholder="Escribe el nombre de la fletera"
                    value="{{ old('name_freight', $invoice->name_freight) }}" name="name_freight" step="any"
                    @if ($rol != 1) readonly @endif>
                @if ($errors->has('name_freight'))
                    <span id="name_freight-error" class="error text-danger" for="input-name_freight">
                        {{ $errors->first('name_freight') }}
                    </span>
                @endif
            </div>
        </div>
        @if ($rol == 1)
            <div class="row justify-content-center">
                <div class="col-12 col-sm-6">
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
                                <input type="file" name="file_pdf" accept=".pdf">
                            </span>
                        </div>
                        @if ($errors->has('file_pdf'))
                            <span id="text-file_pdf" class="error text-danger" for="input-file_pdf">
                                <br> {{ $errors->first('file_pdf') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-sm-6">
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
                                <input type="file" name="file_xml" accept=".xml">
                            </span>
                        </div>
                        @if ($errors->has('file_xml'))
                            <span id="text-file_xml" class="error text-danger" for="input-file_xml">
                                <br> {{ $errors->first('file_xml') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer justify-content-center">
                <button id="send" type="button" class="btn btn-primary"
                    onclick="disabledButton('send','invoice')">{{ __('Actualizar datos del pedido') }}</button>
            </div>
        @endif
    </div>
</div>
