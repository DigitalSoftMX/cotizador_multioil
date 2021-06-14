<?php

namespace App\Http\Controllers;

use App\CompetitionPrice;
use App\Events\EmailMultioil;
use App\Exports\OrdersExport;
use App\Fee;
use App\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Terminal;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        return view('orders.index', ['terminals' => Terminal::all()]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $request = $request->liters_r == null ? $request->merge(['liters_r' => 0]) : $request;
        $request = $request->liters_p == null ? $request->merge(['liters_p' => 0]) : $request;
        $request = $request->liters_d == null ? $request->merge(['liters_d' => 0]) : $request;
        $prices = CompetitionPrice::where([['company_id', $request->company_id], ['terminal_id', $request->terminal_id]])->get()->last();
        $fees = Fee::where([['company_id', $request->company_id], ['terminal_id', $request->terminal_id]])->get()->last();
        $request->merge([
            'total_r' => $request->liters_r * (($prices != null ? $prices->regular : 0) + ($fees != null ? $fees->regular_fit : 0)),
            'total_p' => $request->liters_p * (($prices != null ? $prices->premium : 0) + ($fees != null ? $fees->premium_fit : 0)),
            'total_d' => $request->liters_d * (($prices != null ? $prices->diesel : 0) + ($fees != null ? $fees->diesel_fit : 0)),
        ]);
        $request->merge(['total' => $request->total_r + $request->total_p + $request->total_d, $request->date => now()->modify('+1 day')->format('Y-m-d'), 'status_id' => 1]);
        $order = Order::create($request->all());
        event(new EmailMultioil($order, 1));
        return redirect()->route('orders.index')->withStatus(__('Pedido realizado correctamente.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }
    // Generar excel
    public function downloadExcel(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        return Excel::download(new OrdersExport, 'confirmacion_pedidos-diarios.xlsx');
        return 'generar excel';
    }
    public function export()
    {
        return view('exports.dailyorders', ['orders' => Order::all()]);
    }
}
