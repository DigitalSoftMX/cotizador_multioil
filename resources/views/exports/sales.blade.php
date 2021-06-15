<table border="1">
    <thead>
        <tr>
            <td style="font-weight:bold" align="center">{{ __('ID') }}</td>
            <td style="font-weight:bold" align="center">{{ __('Cliente') }}</td>
            <td style="font-weight:bold" align="center">{{ __('Flete') }}</td>
            <td style="font-weight:bold" align="center">{{ __('C. Reg') }}</td>
            <td style="font-weight:bold" align="center">{{ __('C. Sup') }}</td>
            <td style="font-weight:bold" align="center">{{ __('C. Diésel') }}</td>
            <td style="font-weight:bold" align="center">{{ __('V. Regular') }}</td>
            <td style="font-weight:bold" align="center">{{ __('V. Supreme') }}</td>
            <td style="font-weight:bold" align="center">{{ __('V. Diésel') }}</td>
            <td style="font-weight:bold" align="center">{{ __('Lts. solicitado') }}</td>
            {{-- <td style="font-weight:bold" align="center">{{ __('Producto') }}</td> --}}
            <td style="font-weight:bold" align="center">{{ __('Aprox. a pagar') }}</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td></td>
                <td>{{ $order->company->name }}</td>
                <td style="font-weight:bold">{{ $order->freight == 1 ? 'Si' : 'No' }}</td>
                <td>
                    {{ $order->liters_r != 0
    ? '$ ' .
        number_format(
            $order->terminal->precios()->where('company_id', $order->company_id)->get()->last()->regular,
            2,
        )
    : '--' }}
                </td>
                <td>
                    {{ $order->liters_p != 0
    ? '$ ' .
        number_format(
            $order->terminal->precios()->where('company_id', $order->company_id)->get()->last()->premium,
            2,
        )
    : '--' }}
                </td>
                <td>
                    {{ $order->liters_d != 0
    ? '$ ' .
        number_format(
            $order->terminal->precios()->where('company_id', $order->company_id)->get()->last()->diesel,
            2,
        )
    : '--' }}
                </td>
                <td>
                    {{ $order->liters_r != 0
    ? '$ ' .
        number_format(
            $order->terminal->precios()->where('company_id', $order->company_id)->get()->last()->regular +
                ($order->terminal->fits()->where('company_id', $order->company_id)->get()->last() != null
                    ? $order->terminal->fits()->where('company_id', $order->company_id)->get()->last()->regular_fit
                    : 0),
            2,
        )
    : '--' }}
                </td>
                <td>
                    {{ $order->liters_p != 0
    ? '$ ' .
        number_format(
            $order->terminal->precios()->where('company_id', $order->company_id)->get()->last()->premium +
                ($order->terminal->fits()->where('company_id', $order->company_id)->get()->last() != null
                    ? $order->terminal->fits()->where('company_id', $order->company_id)->get()->last()->premium_fit
                    : 0),
            2,
        )
    : '--' }}
                </td>
                <td>
                    {{ $order->liters_d != 0
    ? '$ ' .
        number_format(
            $order->terminal->precios()->where('company_id', $order->company_id)->get()->last()->diesel +
                ($order->terminal->fits()->where('company_id', $order->company_id)->get()->last() != null
                    ? $order->terminal->fits()->where('company_id', $order->company_id)->get()->last()->diesel_fit
                    : 0),
            2,
        )
    : '--' }}
                </td>
                <td>{{ number_format($order->liters_r + $order->liters_p + $order->liters_d) }}</td>
                <td>{{ '$ ' . number_format($order->total) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
