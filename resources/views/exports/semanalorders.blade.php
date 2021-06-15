
        @foreach ($pedidos as $pedido)
        <table >
        <tr>
        <th style="font-weight:bold" bgcolor="#CCE6FF" colspan="8"  align="center"> Semana del {{ $pedido->monday }} al {{ $pedido->saturday}}</th>
        <th style="font-weight:bold" bgcolor="#FFFFB3" color="red" align="center">LITROS</th>
        </tr>
        
        <tr >
            <td style="font-weight:bold" bgcolor="#CCE6FF" align="center">Ship To</td>
            <td style="font-weight:bold" bgcolor="#cce6ff" align="center">Estación</td>
            <td style="font-weight:bold" bgcolor="#cce6ff" align="center" width="10">Lunes</td>
            <td style="font-weight:bold" bgcolor="#cce6ff" align="center" width="10">Martes</td>
            <td style="font-weight:bold" bgcolor="#cce6ff" align="center" width="10">Miércoles</td>
            <td style="font-weight:bold" bgcolor="#cce6ff" align="center" width="10">Jueves</td>
            <td style="font-weight:bold" bgcolor="#cce6ff" align="center" width="10">Viernes</td>
            <td style="font-weight:bold" bgcolor="#cce6ff" align="center" width="10">Sábado</td>
            <td style="font-weight:bold" bgcolor="#cce6ff" align="center" width="10">Subtotal</td>

           
          
           
            
        </tr>
        
            <tr>
                 <td bgcolor="#CCE6FF" align="center">{{ __('6002936') }}</td>
                <td bgcolor="#FFFFB3" align="center" width="40">{{ __('LA GUERRERA & OIL ENERGY S.A. DE C.V.') }}</td>
                <td align="center">{{ $pedido->monday }} </td>
                <td align="center">{{ $pedido->tuesday }} </td>
                <td align="center">{{ $pedido->wednesday }} </td>
                <td align="center">{{ $pedido->thursday}} </td>
                <td align="center">{{ $pedido->friday }} </td>
                <td align="center">{{ $pedido->saturday }} </td>
                <td align="center">{{ $pedido->grantotal}} </td>
                
            </tr>
        
            <tr>
            <td align="center" >{{ __('Producto') }}</td>
                <td align="center">{{ __('Regular') }}</td>
                <td align="center">{{ number_format($pedido->regularL, 0) }} LTS</td>
                <td align="center">{{ number_format($pedido->regularMa, 0) }} LTS</td>
                <td align="center">{{ number_format($pedido->regularMi, 0) }} LTS</td>
                <td align="center">{{ number_format($pedido->regularJ, 0) }} LTS </td>
                <td align="center">{{ number_format($pedido->regularV, 0) }} LTS</td>
                <td align="center">{{ number_format($pedido->regularS, 0) }} LTS </td>
                <td align="center">{{ number_format($pedido->totalR, 0) }} LTS</td>
            </tr>
            <tr>
            <td align="center">{{ __('Producto') }}</td>
                <td align="center">{{ __('Premium') }}</td>
                <td align="center">{{ number_format($pedido->premiumL, 0) }} LTS</td>
                <td align="center">{{ number_format($pedido->premiumMa, 0) }} LTS</td>
                <td align="center">{{ number_format($pedido->premiumMi, 0) }} LTS</td>
                <td align="center">{{ number_format($pedido->premiumJ, 0) }} LTS </td>
                <td align="center">{{ number_format($pedido->premiumV, 0) }} LTS</td>
                <td align="center">{{ number_format($pedido->premiumS, 0) }} LTS </td>
                <td align="center">{{ number_format($pedido->totalP, 0) }} LTS</td>
            </tr>
       
            <tr>
            <td align="center">{{ __('Producto') }}</td>
                <td align="center">{{ __('Diésel') }}</td>
                <td align="center">{{ number_format($pedido->dieselL, 0) }} LTS</td>
                <td align="center">{{ number_format($pedido->dieselMa, 0) }} LTS</td>
                <td align="center">{{ number_format($pedido->dieselMi, 0) }} LTS</td>
                <td align="center">{{ number_format($pedido->dieselJ, 0) }} LTS </td>
                <td align="center">{{ number_format($pedido->dieselV, 0) }} LTS</td>
                <td align="center">{{ number_format($pedido->dieselS, 0) }} LTS </td>
                <td align="center">{{ number_format($pedido->totalD, 0) }} LTS</td>
            </tr>
      
            
     
    </table>
           
        @endforeach
   
