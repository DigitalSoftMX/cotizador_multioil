<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <br>
    <strong class="font-weight-bold">Fecha de solicitud: </strong>{{ now()->format('Y-m-d') }}<br>
    <strong class="font-weight-bold">Fecha de entrega: </strong>{{ $order->date }}<br>
    <strong class="font-weight-bold">Empresa: </strong>{{ $order->company->name }}<br>
    <strong class="font-weight-bold">Terminal: </strong>{{ $order->terminal->name }}<br><br>
    <table style="width:100%">
        <tr align="left">
            <th>Concepto</th>
            <th>Litros</th>
            <th>Importe</th>
        </tr>
        @if ($order->liters_r != 0)
            <tr>
                <td>Regular</td>
                <td>{{ number_format($order->liters_r, 0) }} LTS</td>
                <td>{{ '$ ' . number_format($order->total_r, 2) }}</td>
            </tr>
        @endif
        @if ($order->liters_p != 0)
            <tr>
                <td>Premium</td>
                <td>{{ number_format($order->liters_p, 0) }} LTS</td>
                <td>{{ '$ ' . number_format($order->total_p, 2) }}</td>
            </tr>
        @endif
        @if ($order->liters_d != 0)
            <tr>
                <td>Diesel</td>
                <td>{{ number_format($order->liters_d, 0) }} LTS</td>
                <td>{{ '$ ' . number_format($order->total_d, 2) }}</td>
            </tr>
        @endif
        <tr align="right">
            <th colspan="2">Total: </th>
            <th>{{ '$ ' . number_format($order->total, 2) }}</th>
        </tr>
    </table>
    <strong class="font-weight-bold"> ¿Requiere flete? : </strong>{{ $order->freight == 0 ? 'No' : 'Si' }}<br>
    <strong class="font-weight-bold"> ¿Seguro de flete? : </strong>{{ $order->secure == 0 ? 'No' : 'Si' }}<br>
</body>

</html>
