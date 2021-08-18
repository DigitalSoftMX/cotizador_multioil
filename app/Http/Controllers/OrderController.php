<?php

namespace App\Http\Controllers;

use App\CompetitionPrice;
use App\Events\EmailMultioil;
use App\Exports\OrdersExport;
use App\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Repositories\Activities;
use App\Terminal;
use App\User;
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
        $datestart = date("m-d-Y", strtotime(date('Y-m-d') . "+ 1 days"));
        $dateend = date("m-d-Y", strtotime(date('Y-m-d') . (date('N') == 5) ? "+ 3 days" : '+1 days'));
        $lock = false;
        if (auth()->user()->company_id != null) {
            if (date('N') > 5) {
                $lock = true;
            }
            return view(
                'orders.index',
                ['terminals' => Terminal::all(), 'company' => auth()->user()->company, 'lock' => $lock, 'day' => date('N'), 'datestart' => $datestart, 'dateend' => $dateend]
            );
        }
        $datestart = '01-01-' . date("Y");
        $dateend = '12-31-' . date("Y");
        return view(
            'orders.index',
            ['terminals' => Terminal::all(), 'lock' => $lock, 'day' => 5, 'datestart' => $datestart, 'dateend' => $dateend]
        );
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
        request()->validate(['date' => 'required|date']);
        /* $datestart = date("Y-m-d", strtotime(date('Y-m-d') . "+ 1 days"));
        $dateend = date("Y-m-d", strtotime(date('Y-m-d') . (date('N') == 5) ? "+ 3 days" : '+1 days'));
        if ($request->date < $datestart || $request->date > $dateend) {
            return redirect()->back()->withStatus('Elija una fecha que se encuentre dentro del rango del calendario')->withColor('danger');
        } */
        if (auth()->user()->roles->first()->id == 2) {
            $lock = false;
            if (date('N') > 5) {
                $lock = true;
            }
            if ($lock) {
                return redirect()->back()->withStatus('Los pedidos solo se pueden realizar de lunes a viernes')->withColor('danger');
            }
        }
        $request = $request->liters_r == null ? $request->merge(['liters_r' => 0]) : $request;
        $request = $request->liters_p == null ? $request->merge(['liters_p' => 0]) : $request;
        $request = $request->liters_d == null ? $request->merge(['liters_d' => 0]) : $request;
        $price = CompetitionPrice::where([['company_id', $request->company_id], ['terminal_id', $request->terminal_id]])->get()->last();
        $request->merge([
            'total_r' => $request->liters_r * (($price != null ? $price->regular : 0)),
            'total_p' => $request->liters_p * (($price != null ? $price->premium : 0)),
            'total_d' => $request->liters_d * (($price != null ? $price->diesel : 0)),
        ]);
        if (date('N') != 5) {
            // $request->merge(['total' => ($request->total_r + $request->total_p + $request->total_d), 'date' => now()->modify('+1 day')->format('Y-m-d'), 'status_id' => 1]);
            $request->merge(['total' => ($request->total_r + $request->total_p + $request->total_d)]);
        } else {
            $request->merge(['total' => ($request->total_r + $request->total_p + $request->total_d), 'status_id' => 1]);
        }
        try {
            event(new EmailMultioil($request, 1));
        } catch (Exception $e) {
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
        if ($request->commission != null || $request->user_id != null)
            request()->validate(['commission' => 'required|numeric', 'user_id' => 'required|integer']);
        if ($request->commission_two != null || $request->middleman_id != null)
            request()->validate(['commission_two' => 'required|numeric', 'middleman_id' => 'required|integer',]);
        if ($request->user_id == $request->middleman_id)
            return redirect()->back()->withStatus('Los comisionistas deben ser diferentes')->withColor('danger');
        $order->update($request->only('commission', 'user_id', 'commission_two', 'middleman_id'));
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
        // return view('exports.sales', ['orders' => Order::where('status_id', 2)->get()]);
        return Excel::download(new OrdersExport(2), 'Ventas.xlsx');
    }
    // Vista para el estado de cuenta de un comisionista
    public function getShoppingsCommision(Request $request, User $user)
    {
        $request->user()->authorizeRoles(['Administrador', 'Ventas']);
        $months = new Activities();
        return view('orders.commission', ['user' => $user, 'activePage' => auth()->user()->roles->first()->id == 3 ? 'Estado de cuenta' : 'Usuarios', 'months' => $months->getMonths()]);
    }
    // Obtener el estado de cuenta de un comisionista
    public function commission(Request $request, User $user, $month)
    {
        $request->user()->authorizeRoles(['Administrador', 'Ventas']);
        $total = 0;
        $sales = [];
        foreach (Order::where([['status_id', 2], ['user_id', $user->id]])->whereMonth('dispatched', $month)->get() as $order) {
            $data['company'] = $order->company->name;
            $data['date'] = $order->dispatched != null ? date('d/m/Y', strtotime($order->dispatched)) : '-';
            $data['cfdi'] = $order->CFDI;
            $data['product'] = strtoupper($order->product);
            $data['liters'] = number_format($order->liters, 2);
            $data['centsPerLiter'] = '$' . number_format($order->commission, 2);
            $data['commission'] = '$' . number_format($sum = $order->commission * $order->liters, 2);
            array_push($sales, $data);
            $total += $sum;
        }
        return response()->json([
            'sales' => $sales,
            'total' => '$' . number_format($total, 2)
        ]);
    }
    // método para descargar excel con las comisiones de un ususario ventas
    public function commissionexcel(Request $request, User $user)
    {
        $request->user()->authorizeRoles(['Administrador', 'Ventas']);
        // return view('exports.commissionsales', ['orders' => $user->orders->where('status_id', 2)]);
        return Excel::download(new OrdersExport(3, $user), "Comisiones de {$user->name} {$user->app_name}.xlsx");
    }
}
