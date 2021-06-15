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
                <table style="width:100%">
        <tr align="left">
            <th>Fecha/Producto</th>
            <th>Regular</th>
            <th>Premium</th>
            <th>Diésel</th>

           
          
           
            
        </tr>
        
            <tr>
                <td>Lunes: {{ $pedido->monday }} </td>
                <td>{{ number_format($pedido->regularL, 0) }} LTS</td>
                <td>{{ number_format($pedido->premiumL, 0) }} LTS</td>
                <td>{{ number_format($pedido->dieselL, 0) }} LTS</td>
                
            </tr>
        
            <tr>
                <td>Martes: {{ $pedido->tuesday }} </td>
                <td>{{ number_format($pedido->regularMa, 0) }} LTS</td>
                <td>{{ number_format($pedido->premiumMa, 0) }} LTS</td>
                <td>{{ number_format($pedido->dieselMa, 0) }} LTS</td>
            </tr>
       
            <tr>
                <td>Miércoles: {{ $pedido->wednesday }} </td>
                <td>{{ number_format($pedido->regularMi, 0) }} LTS</td>
                <td>{{ number_format($pedido->premiumMi, 0) }} LTS</td>
                <td>{{ number_format($pedido->dieselMi, 0) }} LTS</td>
            </tr>
            <tr>
                <td>Jueves: {{ $pedido->thursday }} </td>
                <td>{{ number_format($pedido->regularJ, 0) }} LTS</td>
                <td>{{ number_format($pedido->premiumJ, 0) }} LTS</td>
                <td>{{ number_format($pedido->dieselJ, 0) }} LTS</td>
            </tr>
            <tr>
                <td>Viernes: {{ $pedido->friday }} </td>
                <td>{{ number_format($pedido->regularV, 0) }} LTS</td>
                <td>{{ number_format($pedido->premiumV, 0) }} LTS</td>
                <td>{{ number_format($pedido->dieselV, 0) }} LTS</td>
            </tr>
            <tr>
                <td>Sábado: {{ $pedido->saturday }} </td>
                <td>{{ number_format($pedido->regularS, 0) }} LTS</td>
                <td>{{ number_format($pedido->premiumS, 0) }} LTS</td>
                <td>{{ number_format($pedido->dieselS, 0) }} LTS</td>
            </tr>
            <tr>
                <td>Subtotal </td>
                <td>{{ number_format($pedido->totalR, 0) }} LTS</td>
                <td>{{ number_format($pedido->totalP, 0) }} LTS</td>
                <td>{{ number_format($pedido->totalD, 0) }} LTS</td>
            </tr>
     
    </table>
    <h6>Total de litros: {{ number_format($pedido->grantotal, 0) }} LTS</h6>
    <h6>¿Requiere flete?: {{ ($pedido->nflete) }} </h6>
    <h6>¿Requiere seguro para su flete?: {{ ($pedido->nseguro) }} </h6>
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
