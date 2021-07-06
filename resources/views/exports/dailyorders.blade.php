<table border="1">
    <thead>
        <tr>
            <td style="font-weight:bold;vertical-align:center" align="center" rowspan="2" bgcolor="#10B9D3">{{ __('Ship To') }}</td>
            <td style="font-weight:bold;vertical-align:center" align="center" rowspan="2" bgcolor="#10B9D3" width="14">{{ __('Estación') }}</td>
            <td style="font-weight:bold;vertical-align:center" align="center" rowspan="2" bgcolor="#10B9D3" width="13">{{ __('Fecha') }}</td>
            <td style="font-weight:bold;vertical-align:center" align="center" colspan="3" bgcolor="#10B9D3">{{ __('Producto') }}</td>
            <td style="font-weight:bold;vertical-align:center" align="center" rowspan="2" bgcolor="#10B9D3" width="20">{{ __('Alias') }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold;vertical-align:center" align="center" bgcolor="#10B9D3" width="11">{{ __('Regular') }}</td>
            <td style="font-weight:bold;vertical-align:center" align="center" bgcolor="#10B9D3" width="11">{{ __('Premium') }}</td>
            <td style="font-weight:bold;vertical-align:center" align="center" bgcolor="#10B9D3" width="11">{{ __('Diésel') }}</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td style="font-weight:bold;vertical-align:center" align="center">{{ __('6002936') }}</td>
                <td style="vertical-align:center" height="40" align="center">
                    <p style="text-align: justify;">{{ __('LA GUERRERA & OIL ENERGY S.A. DE C.V.') }}</p>
                </td>
                <td style="vertical-align:center" align="center">{{ date('d/m/Y', strtotime($order->date)) }}</td>
                <td style="vertical-align:center" align="center">{{ $order->product == 'regular' ? number_format($order->liters) : '' }}</td>
                <td style="vertical-align:center" align="center">{{ $order->product == 'premium' ? number_format($order->liters) : '' }}</td>
                <td style="vertical-align:center" align="center">{{ $order->product == 'diesel' ? number_format($order->liters) : '' }}</td>
                <td style="vertical-align:center" align="center">
                    <p style="text-align: justify;">{{ $order->company->name }}</p>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
