<?php

namespace App\Http\Controllers;
use App\Events\EmailMultioil;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pedido;

class validacionSController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        return view('validacionS.index', ['pedidos' => Pedido::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    // acceptar un pedido
    public function accept(Request $request, Pedido $pedido)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $pedido->update(['status_id' => 2]);
       event(new EmailMultioil($pedido, 5));
        return redirect()->back()->withStatus('Pedido autorizado correctamente');
    }
    // denegar un pedido
    public function deny(Request $request, Pedido $pedido)
    {
        $request->user()->authorizeRoles(['Administrador']);
        if ($request->message == null)
            return redirect()->back()->withStatus('Ingrese el motivo por el cual se deniega el pedido')->withColor('danger');
        $pedido->update(['status_id' => 3]);
        event(new EmailMultioil($pedido, 6, $request->message));
        return redirect()->back()->withStatus('Pedido denegado')->withColor('danger');
    }
   
}
