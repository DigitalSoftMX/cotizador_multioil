<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <br>
    {{ isset($m) ? 'Su pedido ha sido denegado.' : 'Su pedido ha sido aceptado.' }} <br><br>
    @isset($m)
        <b>Motivo: </b> <b style="color:red;">{{ $m }}</b> <br>
    @endisset
    <strong>Detalles del pedido:</strong> <br>
    @if ($order->liters_r > 0)
        <strong>Litros de regular: </strong> {{ number_format($order->liters_r, 2) }} <br>
    @endif
    @if ($order->liters_p > 0)
        <strong>Litros de premium: </strong> {{ number_format($order->liters_p, 2) }} <br>
    @endif
    @if ($order->liters_d > 0)
        <strong>Litros de diesel: </strong> {{ number_format($order->liters_d, 2) }} <br>
    @endif
    <br>
    Por el precio total de: <strong>{{ '$ ' . number_format($order->total, 2) }}</strong>
    @if ($order->freight == 1)
        con fletera {{ $order->secure == 1 ? 'que incluye' : 'que no incluye' }} seguro.
    @endif

</body>

</html>