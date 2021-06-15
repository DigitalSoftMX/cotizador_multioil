<table border="1">
    <thead>
        <tr>
            <td style="font-weight:bold" align="center" rowspan="2" bgcolor="#10B9D3">{{ __('Ship To') }}</td>
            <td style="font-weight:bold" align="center" rowspan="2" bgcolor="#10B9D3">{{ __('Estación') }}</td>
            <td style="font-weight:bold" align="center" rowspan="2" bgcolor="#10B9D3">{{ __('Fecha') }}</td>
            <td style="font-weight:bold" align="center" colspan="3" bgcolor="#10B9D3">{{ __('Producto') }}</td>
            <td style="font-weight:bold" align="center" rowspan="2" bgcolor="#10B9D3">{{ __('Alias') }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold" align="center" bgcolor="#10B9D3">{{ __('Regular') }}</td>
            <td style="font-weight:bold" align="center" bgcolor="#10B9D3">{{ __('Premium') }}</td>
            <td style="font-weight:bold" align="center" bgcolor="#10B9D3">{{ __('Diésel') }}</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td style="font-weight:bold">{{ __('6002936') }}</td>
                <td>{{ __('LA GUERRERA & OIL ENERGY S.A. DE C.V.') }}</td>
                <td>{{ date('Y/m/d', strtotime($order->date)) }}</td>
                <td>{{ number_format($order->total_r, 2) }}</td>
                <td>{{ number_format($order->total_p, 2) }}</td>
                <td>{{ number_format($order->total_d, 2) }}</td>
                <td>{{ $order->company->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
