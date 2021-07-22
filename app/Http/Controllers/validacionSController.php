<?php

namespace App\Http\Controllers;

use App\Events\EmailMultioil;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pedido;
use Exception;

class validacionSController extends Controller
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
            return view('validacionS.index', ['pedidos' => Pedido::where('company_id', auth()->user()->company_id)]);
        }
        return view('validacionS.index', ['pedidos' => Pedido::all()]);
    }

    // acceptar un pedido
    public function accept(Request $request, Pedido $pedido)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $pedido->update(['status_id' => 2]);
        try {
            event(new EmailMultioil($pedido, 5));
        } catch (Exception $th) {
        }
        return redirect()->back()->withStatus('Pedido autorizado correctamente');
    }
    // denegar un pedido
    public function deny(Request $request, Pedido $pedido)
    {
        $request->user()->authorizeRoles(['Administrador']);
        if ($request->message == null)
            return redirect()->back()->withStatus('Ingrese el motivo por el cual se deniega el pedido')->withColor('danger');
        $pedido->update(['status_id' => 3]);
        try {
            event(new EmailMultioil($pedido, 6, $request->message));
        } catch (\Throwable $th) {
        }
        return redirect()->back()->withStatus('Pedido denegado')->withColor('danger');
    }
}
