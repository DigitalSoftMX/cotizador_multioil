<?php

namespace App\Http\Controllers;

use App\Events\EmailMultioil;
use App\Http\Controllers\Controller;
use App\Order;
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
        $order->update(['status_id' => 2]);
        event(new EmailMultioil($order, 2));
        return redirect()->back()->withStatus('Pedido autorizado correctamente');
    }
    // denegar un pedido
    public function deny(Request $request, Order $order)
    {
        $request->user()->authorizeRoles(['Administrador']);
        if ($request->message == null)
            return redirect()->back()->withStatus('Ingrese el motivo por el cual se deniega el pedido')->withColor('danger');
        $order->update(['status_id' => 3]);
        event(new EmailMultioil($order, 3, $request->message));
        return redirect()->back()->withStatus('Pedido denegado')->withColor('danger');
    }
}
