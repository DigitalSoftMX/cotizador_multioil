<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    <strong>{{ __('Datos del pedido:') }}</strong>
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <h6>{{ 'Empresa: ' . $invoice->company->name }}</h6>
                        <h6>{{ 'Terminal: ' . $invoice->terminal->name }}</h6>
                        <h6>{{ 'Producto: ' }} {{ $invoice->product }}
                            {{ 'litros: ' }}
                            {{ number_format($invoice->liters, 0) . ' lts' }} <br>
                            {{ 'importe: ' }}
                            {{ '$ ' . number_format($invoice->total, 2) }}
                        </h6>
                    </div>
                    <div class="col-12 col-md-4">
                        <label>
                            <h6>Cantidad a pagar:</h6>
                        </label>
                        <strong>
                            {{ '$ ' . number_format($invoice->invoice > 0 ? $invoice->invoice + $invoice->invoice2 - $invoice->amount : $invoice->total, 2) }}
                        </strong><br>
                        <label>
                            <h6>Cantidad pagada:</h6>
                        </label>
                        <strong>{{ '$ ' . number_format($invoice->payments->sum('payment_guerrera'), 2) }}</strong>
                        <br>
                        <label>
                            <h6>Cantidad restante:</h6>
                        </label>
                        <strong
                            style="{{ ($total = ($invoice->invoice > 0 ? $invoice->invoice + $invoice->invoice2 : $invoice->total) - $invoice->payments->sum('payment_guerrera')) > 0 ? 'color:red;' : 'color:blue;' }}">
                            {{ '$ ' . number_format($total, 2) }}
                        </strong>
                    </div>
                    <div class="col-12 col-md-4">
                        <label>
                            <h6>Cliente La Guerrera:</h6>
                        </label>
                        <strong>{{ '$ ' . number_format($invoice->payments->sum('payment_guerrera'), 2) }}</strong><br>
                        <label>
                            <h6>Cliente La Guerrera Valero:</h6>
                        </label>
                        <strong>{{ '$ ' . number_format($invoice->payments->sum('payment_g_valero'), 2) }}</strong><br>
                        <label>
                            <h6>Fletera:</h6>
                        </label>
                        <strong>{{ '$ ' . number_format($invoice->payments->sum('payment_freight'), 2) }}</strong><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
