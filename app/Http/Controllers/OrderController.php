<?php

namespace App\Http\Controllers;

use App\CompetitionPrice;
use App\Events\EmailMultioil;
use App\Exports\OrdersExport;
use App\Fee;
use App\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Repositories\Activities;
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
        $price = CompetitionPrice::where([['company_id', $request->company_id], ['terminal_id', $request->terminal_id]])->get()->last();
        $request->merge([
            'total_r' => $request->liters_r * (($price != null ? $price->regular : 0)),
            'total_p' => $request->liters_p * (($price != null ? $price->premium : 0)),
            'total_d' => $request->liters_d * (($price != null ? $price->diesel : 0)),
        ]);
        $request->merge(['total' => ($request->total_r + $request->total_p + $request->total_d), 'date' => now()->modify('+1 day')->format('Y-m-d'), 'status_id' => 1]);
        try {
            event(new EmailMultioil($request, 1));
        } catch (Exception $e) {
            return redirect()->back()->withStatus('No existe un usuario asociado a la empresa seleccionada')->withColor('danger');
        }
        $register = new Activities();
        if ($request->total_r)
            $register->register($request->all(), 'r');
        if ($request->total_p)
            $register->register($request->all(), 'p');
        if ($request->total_d)
            $register->register($request->all(), 'd');
        return redirect()->route('orders.index')->withStatus(__('Pedido realizado correctamente.'));
    }
    // Atualizacion del pedido para comision y usuario ventas
    public function update(Request $request, Order $order)
    {
        $request->user()->authorizeRoles(['Administrador']);
        request()->validate(['commission' => 'required|numeric', 'user_id' => 'required|integer']);
        $order->update($request->only('commission', 'user_id'));
        return redirect()->back()->withStatus('Comisión del pedido agregado correctamente');
    }
    // Generar excel
    public function downloadExcel(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador', 'Cliente']);
        return Excel::download(new OrdersExport(1), 'Confirmacion_pedidos-diarios.xlsx');
    }
    // Generar excel de ventas
    public function downloadSales(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador', 'Cliente']);
        return Excel::download(new OrdersExport(2), 'Ventas.xlsx');
    }
}
