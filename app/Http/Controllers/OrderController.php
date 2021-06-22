<?php

namespace App\Http\Controllers;

use App\CompetitionPrice;
use App\Events\EmailMultioil;
use App\Exports\OrdersExport;
use App\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Terminal;
use Exception;
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
        $request->user()->authorizeRoles(['Administrador', 'Cliente']);
        if (auth()->user()->company_id != null) {
            return view('orders.index', ['terminals' => Terminal::all(), 'company' => auth()->user()->company]);
        }
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
        $request->user()->authorizeRoles(['Administrador', 'Cliente']);
        $request = $request->liters_r == null ? $request->merge(['liters_r' => 0]) : $request;
        $request = $request->liters_p == null ? $request->merge(['liters_p' => 0]) : $request;
        $request = $request->liters_d == null ? $request->merge(['liters_d' => 0]) : $request;
        $prices = CompetitionPrice::where([['company_id', $request->company_id], ['terminal_id', $request->terminal_id]])->get()->last();
        $request->merge([
            'total_r' => $request->liters_r * (($prices != null ? $prices->regular : 0)),
            'total_p' => $request->liters_p * (($prices != null ? $prices->premium : 0)),
            'total_d' => $request->liters_d * (($prices != null ? $prices->diesel : 0)),
        ]);
        $request->merge(['total' => $request->total_r + $request->total_p + $request->total_d, $request->date => now()->modify('+1 day')->format('Y-m-d'), 'status_id' => 1]);
        $order = Order::create($request->all());
        try {
            event(new EmailMultioil($order, 1));
        } catch (Exception $e) {
            $order->delete();
            return redirect()->back()->withStatus('No hay un usuario asociado a la empresa seleccionada')->withColor('danger');
        }
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
        $request->user()->authorizeRoles(['Administrador', 'Cliente']);
        return Excel::download(new OrdersExport(1), 'confirmacion_pedidos-diarios.xlsx');
    }
    // Generar excel de ventas
    public function downloadSales(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador', 'Cliente']);
        return Excel::download(new OrdersExport(2), 'Ventas_Impulsa.xlsx');
    }
    public function export()
    {
        return view('exports.sales', ['orders' => Order::all()]);
    }
}
