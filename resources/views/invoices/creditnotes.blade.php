@if (($rol = auth()->user()->roles->first()->id) == 1)
    <form id="creditForm" action="{{ route('credit', $invoice) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card ">
            <div class="card-header">
                <h4 class="card-title">
                    <strong>{{ __('Nota de crédito') }}</strong>
                </h4>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-10 text-right">
                        @if ($invoice->creditpdf != null)
                            <a href="{{ route('download', [$invoice, 'creditpdf', 'pdf']) }}"
                                class="btn btn-sm btn-success">{{ __('Descargar pdf') }}</a>
                        @endif
                        @if ($invoice->creditxml != null)
                            <a href="{{ route('download', [$invoice, 'creditxml', 'xml']) }}"
                                class="btn btn-sm btn-success">{{ __('Descargar xml') }}</a>
                        @endif
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-md-5 col-sm-12">
                        <label for="credit">{{ __('Folio nota de crédito') }}
                        </label>
                        <input type="text" class="form-control" id="input-credit" aria-describedby="creditHelp"
                            placeholder="Nota de crédito" value="{{ old('credit', $invoice->credit) }}" readonly>
                    </div>
                    <div class="form-group col-md-5 col-sm-12">
                        <label for="amount">{{ __('Importe final') }}</label>
                        <input type="text" class="form-control" id="input-amount" aria-describedby="amountHelp"
                            placeholder="Importe final" value="{{ old('amount', $invoice->amount) }}" step="any"
                            readonly>
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
                                            @if ($invoice->creditpdf ?? false)
                                                {{ __('Cambiar archivo') }}
                                            @else
                                                {{ __('Agregar archivo') }}
                                            @endif
                                        </span>
                                        <span class="fileinput-exists">Cambiar
                                            archivo</span>
                                        <input type="file" name="file_creditpdf" accept=".pdf">
                                    </span>
                                </div>
                                @include('partials.errorsession',[$field='file_creditpdf'])
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                <label>{{ __('Factura XML') }}</label>
                                <div class="justify-content-center">
                                    <span class="btn btn-rose btn-sm btn-file">
                                        <span class="fileinput-new">
                                            @if ($invoice->creditxml ?? false)
                                                {{ __('Cambiar archivo') }}
                                            @else
                                                {{ __('Agregar archivo') }}
                                            @endif
                                        </span>
                                        <span class="fileinput-exists">Cambiar
                                            archivo</span>
                                        <input type="file" name="file_creditxml" accept=".xml">
                                    </span>
                                </div>
                                @include('partials.errorsession',[$field='file_creditxml'])
                            </div>
                        </div>
                    </div>
                    <div class="card-footer justify-content-center">
                        <button id="creditButton" type="button" onclick="disabledButton('creditButton','creditForm')"
                            class="btn btn-primary">{{ __('Actualizar nota de crédito') }}
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </form>
@endif
