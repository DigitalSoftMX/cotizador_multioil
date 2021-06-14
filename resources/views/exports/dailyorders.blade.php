<table>
    <thead>
        <tr>
            <th rowspan="2" bgcolor="#10B9D3">{{ __('Ship To') }}</th>
            <th rowspan="2" bgcolor="#10B9D3">{{ __('Estación') }}</th>
            <th rowspan="2" bgcolor="#10B9D3">{{ __('Fecha') }}</th>
            <th colspan="3" bgcolor="#10B9D3">{{ __('Producto') }}</th>
            <th rowspan="2" bgcolor="#10B9D3">{{ __('Alias') }}</th>
        </tr>
        <tr>
            <th bgcolor="#10B9D3">{{ __('Regular') }}</th>
            <th bgcolor="#10B9D3">{{ __('Premium') }}</th>
            <th bgcolor="#10B9D3">{{ __('Diésel') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ __('6002936') }}</td>
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
