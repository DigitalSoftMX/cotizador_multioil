<table border="1">
    <thead>
        <tr>
            <td style="font-weight:bold;color:#ffffff;vertical-align:center" align="center" bgcolor="#000000"  width="16" height="30">
                <p style="text-align: justify;">{{ __('EMPRESA') }}</p>
            </td>
            <td style="font-weight:bold;color:#ffffff;vertical-align:center" align="center" bgcolor="#000000"  width="16">
                <p style="text-align: justify;">{{ __('FECHA DE CARGA') }}</p>
            </td>
            <td style="font-weight:bold;color:#ffffff;vertical-align:center" align="center" bgcolor="#000000"  width="16">
                <p style="text-align: justify;">{{ __('FACTURA') }}</p>
            </td>
            <td style="font-weight:bold;color:#ffffff;vertical-align:center" align="center" bgcolor="#000000"  width="16">
                <p style="text-align: justify;">{{ __('PRODUCTO') }}</p>
            </td>
            <td style="font-weight:bold;color:#ffffff;vertical-align:center" align="center" bgcolor="#000000"  width="16">
                <p style="text-align: justify;">{{ __('LITROS') }}</p>
            </td>
            <td style="font-weight:bold;color:#ffffff;vertical-align:center" align="center" bgcolor="#000000"  width="16">
                <p style="text-align: justify;">{{ __('CENTAVOS POR LITRO') }}</p>
            </td>
            <td style="font-weight:bold;color:#ffffff;vertical-align:center" align="center" bgcolor="#000000"  width="16">
                <p style="text-align: justify;">{{ __('COMISIÓN') }}</p>
            </td>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        @foreach ($orders as $order)
            <tr>
                <td width="40">{{$order->company->name}}</td>
                <td>{{$order->dispatched != null ? date('d/m/Y', strtotime($order->dispatched)) : '-'}}</td>
                <td>{{$order->CFDI}}</td>
                <td>{{strtoupper($order->product)}}</td>
                <td>{{number_format($order->liters, 2)}}</td>
                <td>{{'$' . number_format($order->commission, 2)}}</td>
                <td>{{'$' . number_format($sum = $order->commission * $order->liters, 2)}}</td>
                @php
                    $total += $sum;
                @endphp
            </tr>
        @endforeach
        <tr style="font-weight:bold;vertical-align:center">
            <td colspan="6" align="right">Total</td>
            <td colspan="1">{{'$'.number_format($total,2)}}</td>
        </tr>
    </tbody>
</table>
