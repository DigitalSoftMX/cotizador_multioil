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
    <table style="width:100%">
        <tr align="left">
            <th>Fecha/Producto</th>
            <th>Regular</th>
            <th>Premium</th>
            <th>Diésel</th>

           
          
           
            
        </tr>
        
            <tr>
                <td>Lunes: {{ $order->monday }} </td>
                <td>{{ number_format($order->regularL, 0) }} LTS</td>
                <td>{{ number_format($order->premiumL, 0) }} LTS</td>
                <td>{{ number_format($order->dieselL, 0) }} LTS</td>
                
            </tr>
        
            <tr>
                <td>Martes: {{ $order->tuesday }} </td>
                <td>{{ number_format($order->regularMa, 0) }} LTS</td>
                <td>{{ number_format($order->premiumMa, 0) }} LTS</td>
                <td>{{ number_format($order->dieselMa, 0) }} LTS</td>
            </tr>
       
            <tr>
                <td>Miércoles: {{ $order->wednesday }} </td>
                <td>{{ number_format($order->regularMi, 0) }} LTS</td>
                <td>{{ number_format($order->premiumMi, 0) }} LTS</td>
                <td>{{ number_format($order->dieselMi, 0) }} LTS</td>
            </tr>
            <tr>
                <td>Jueves: {{ $order->thursday }} </td>
                <td>{{ number_format($order->regularJ, 0) }} LTS</td>
                <td>{{ number_format($order->premiumJ, 0) }} LTS</td>
                <td>{{ number_format($order->dieselJ, 0) }} LTS</td>
            </tr>
            <tr>
                <td>Viernes: {{ $order->friday }} </td>
                <td>{{ number_format($order->regularV, 0) }} LTS</td>
                <td>{{ number_format($order->premiumV, 0) }} LTS</td>
                <td>{{ number_format($order->dieselV, 0) }} LTS</td>
            </tr>
            <tr>
                <td>Sábado: {{ $order->saturday }} </td>
                <td>{{ number_format($order->regularS, 0) }} LTS</td>
                <td>{{ number_format($order->premiumS, 0) }} LTS</td>
                <td>{{ number_format($order->dieselS, 0) }} LTS</td>
            </tr>
            <tr>
                <td>Subtotal </td>
                <td>{{ number_format($order->totalR, 0) }} LTS</td>
                <td>{{ number_format($order->totalP, 0) }} LTS</td>
                <td>{{ number_format($order->totalD, 0) }} LTS</td>
            </tr>
     
    </table>
    <p>Total de litros: {{ number_format($order->grantotal, 0) }} LTS</p><br>
</body>

</html>
