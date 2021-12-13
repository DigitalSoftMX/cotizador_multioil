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
                @include('partials.errorsession',[$field='dispatched'])
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }} col-12">
                <label for="price">{{ __('Precio de compra') }}</label>
                <input type="number" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}"
                    id="input-price" aria-describedby="priceHelp" placeholder="Escribe el precio de compra por litro"
                    value="{{ old('price', $invoice->price) }}" name="price" step="any" @if ($rol != 1) readonly @endif>
                @include('partials.errorsession',[$field='price'])
            </div>
        </div>
        @if (auth()->user()->roles->first()->id == 1)
            <div class="row justify-content-center">
                <div class="form-group{{ $errors->has('sale_price') ? ' has-danger' : '' }} col-12">
                    <label for="sale_price">{{ __('Precio Multioil compra') }}</label>
                    <input type="number" class="form-control{{ $errors->has('sale_price') ? ' is-invalid' : '' }}"
                        id="input-sale_price" aria-describedby="sale_priceHelp"
                        placeholder="Escribe el precio de venta por litro"
                        value="{{ old('sale_price', $invoice->sale_price) }}" name="sale_price" step="any"
                        @if ($rol != 1) readonly @endif>
                    @include('partials.errorsession',[$field='sale_price'])
                </div>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('bol_load') ? ' has-danger' : '' }} col-12">
                <label for="bol_load">{{ __('Folio Bol de carga') }}</label>
                <input type="number" class="form-control{{ $errors->has('bol_load') ? ' is-invalid' : '' }}"
                    id="input-bol_load" aria-describedby="bol_loadHelp" placeholder="Escribe el folio bol de carga"
                    value="{{ old('bol_load', $invoice->bol_load) }}" name="bol_load" step="any"
                    @if ($rol != 1) readonly @endif>
                @include('partials.errorsession',[$field='bol_load'])
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
                @include('partials.errorsession',[$field='dispatched_liters'])
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('root_liters') ? ' has-danger' : '' }} col-12">
                <label for="root_liters">{{ __('Litros vendedor v-root') }}</label>
                <input type="number" class="form-control{{ $errors->has('root_liters') ? ' is-invalid' : '' }}"
                    id="input-root_liters" aria-describedby="root_litersHelp" placeholder="Escribe los litros root"
                    value="{{ old('root_liters', $invoice->root_liters) }}" name="root_liters" step="any"
                    @if ($rol != 1) readonly @endif>
                @include('partials.errorsession',[$field='root_liters'])
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group col-12">
                <label for="invoice">{{ __('Cantidad facturada') }}</label>
                <input type="number" class="form-control" id="input-invoice" aria-describedby="invoiceHelp"
                    placeholder="Total cantidad facturada" value="{{ old('invoice', $invoice->invoice) }}" step="any"
                    readonly>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group col-12">
                <label for="invoicefolio">{{ __('Folio') }}</label>
                <textarea class="form-control" id="input-invoicefolio" aria-describedby="invoicefolioHelp"
                    placeholder="Folio" rows="2" readonly>{{ old('invoicefolio', $invoice->invoicefolio) }}
                </textarea>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('CFDI') ? ' has-danger' : '' }} col-12">
                <label for="CFDI">{{ __('Factura') }}</label>
                <input type="text" class="form-control{{ $errors->has('CFDI') ? ' is-invalid' : '' }}"
                    id="input-CFDI" aria-describedby="CFDIHelp" placeholder="Escribe la factura"
                    value="{{ old('CFDI', $invoice->CFDI) }}" name="CFDI" step="any" @if ($rol != 1) readonly @endif>
                @include('partials.errorsession',[$field='CFDI'])
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="form-group{{ $errors->has('name_freight') ? ' has-danger' : '' }} col-12">
                <label for="name_freight">{{ __('Nombre de la fletera') }}</label>
                <input type="text" class="form-control{{ $errors->has('name_freight') ? ' is-invalid' : '' }}"
                    id="input-name_freight" aria-describedby="name_freightHelp"
                    placeholder="Escribe el nombre de la fletera"
                    value="{{ old('name_freight', $invoice->name_freight) }}" name="name_freight"
                    @if ($rol != 1) readonly @endif>
                @include('partials.errorsession',[$field='name_freight'])
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
                        @include('partials.errorsession',[$field='file_pdf'])
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
                        @include('partials.errorsession',[$field='file_xml'])
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
