<?php

namespace App\Http\Controllers;

use App\Events\EmailMultioil;
use App\Http\Controllers\Controller;
use App\Order;
use Exception;
use Illuminate\Http\Request;

class ValidationController extends Controller
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
            return view('validations.index', ['orders' => Order::where('company_id', auth()->user()->company_id)->get()]);
        }
        return view('validations.index', ['orders' => Order::all()]);
    }
    // acceptar un pedido
    public function accept(Request $request, Order $order)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $request->merge(['status_id' => 2, 'reason' => null]);
        $order->update($request->only(['status_id', 'reason', 'type']));
        if (strtotime($order->created_at->format('Y-m-d')) >= strtotime(date("Y-m-d", time()))) {
            try {
                event(new EmailMultioil($order, 2));
            } catch (Exception $th) {
            }
        }
        return redirect()->back()->withStatus('Pedido autorizado correctamente');
    }
    // denegar un pedido
    public function deny(Request $request, Order $order)
    {
        $request->user()->authorizeRoles(['Administrador']);
        if ($request->message == null)
            return redirect()->back()->withStatus('Ingrese el motivo por el cual se deniega el pedido')->withColor('danger');
        $order->update(['status_id' => 3, 'reason' => $request->message]);
        if (strtotime($order->created_at->format('Y-m-d')) >= strtotime(date("Y-m-d", time()))) {
            try {
                event(new EmailMultioil($order, 3, $request->message));
            } catch (Exception $th) {
            }
        }
        return redirect()->back()->withStatus('Pedido denegado')->withColor('danger');
    }
    // Regresar un pedido a pendiente cuando ya fue autorizado
    public function restore(Request $request, Order $order)
    {
        $request->user()->authorizeRoles(['Administrador']);
        if ($request->message == null)
            return redirect()->back()->withStatus('Ingrese el motivo por el cual se deniega el pedido')->withColor('danger');
        $order->update(['status_id' => 1, 'reason' => $request->message]);
        try {
            event(new EmailMultioil($order, 7, $request->message));
        } catch (Exception $th) {
        }
        return redirect()->back()->withStatus('El pedido cambio su estado a pendientes')->withColor('warning');
    }
}
