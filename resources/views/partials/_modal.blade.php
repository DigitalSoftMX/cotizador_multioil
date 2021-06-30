<div class="modal fade" id="exampleModalLong{{ $id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if ($see)
                    <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">
                        {{ __('Detalles del pedido') }}</h5>
                @else
                    <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">
                        {{ __('Escriba el motivo por el cual se niega el pedido') }}</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($see)
                    <strong class="font-weight-bold">Fecha de entrega:
                    </strong>{{ date('Y-m-d', strtotime($order->date)) }}<br>
                    <strong class="font-weight-bold">Terminal: </strong>{{ $order->terminal->name }}<br>
                    <strong class="font-weight-bold">Empresa: </strong>{{ $order->company->name }}
                    <table style="width:100%">
                        <tr>
                            <th>Concepto</th>
                            <th>Litros</th>
                            <th>Importe</th>
                        </tr>
                        <tr>
                            <td>{{ $order->product }}</td>
                            <td>{{ number_format($order->liters, 2) }} LTS</td>
                            <td>{{ '$ ' . number_format($order->total, 2) }}</td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-right">Total: </th>
                            <td>{{ '$ ' . number_format($order->total, 2) }}</td>
                        </tr>
                    </table>
                    <strong class="font-weight-bold"> ¿Requiere flete? :
                    </strong>{{ $order->freight == 0 ? 'No' : 'Si' }}<br>
                    <strong class="font-weight-bold"> ¿Seguro de flete? :
                    </strong>{{ $order->secure == 0 ? 'No' : 'Si' }}<br>
                @else
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">{{ __('Mensaje:') }}</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="message"></textarea>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                @if ($see)
                    <button type="button" class="btn btn-primary btn-lg"
                        data-dismiss="modal">{{ __('Aceptar') }}</button>
                @else
                    <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal"
                        id="cancel">{{ __('Cancelar') }}</button>
                    <button type="submit" class="btn btn-danger btn-lg"
                        id="accept">{{ __('Denegar pedido') }}</button>
                @endif
            </div>
        </div>
    </div>
</div>
