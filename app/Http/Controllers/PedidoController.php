<?php

namespace App\Http\Controllers;

use App\Exports\PedidosExport;
use App\Pedido;
use App\Company;
use App\Events\EmailMultioil;
use App\Terminal;
use App\Http\Controllers\Controller;
use App\Http\Requests\PedidoRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->company_id != null) {
            return view("Pedidos.index", ['terminals' => Terminal::all()], ['company' => auth()->user()->company]);
        }
        return view("Pedidos.index", ['terminals' => Terminal::all()], ['companies' => Company::all()]);
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
    public function store(PedidoRequest $request)
    {
        if (auth()->user()->roles->first()->id == 1) {
            request()->validate(['company_id' => 'required|integer',]);
        }
        if (auth()->user()->roles->first()->id == 2) {
            $request->merge(['company_id' => auth()->user()->company_id]);
        }
        $datosPedido = $request->except('_token');
        Pedido::insert($datosPedido);
        $pedido = Pedido::all()->last();
        event(new EmailMultioil($pedido, 4));
        return redirect()->back()->withStatus('Pedido realizado correctamente');
        return response()->json($datosPedido);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
    public function downloadExcel(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador', 'Cliente']);
        return Excel::download(new PedidosExport, 'confirmacion_pedidos-semanales.xlsx');
        return 'generar excel';
    }
    public function export()
    {
        return view('exports.semanlorders', ['Pedidos' => Pedido::all()]);
    }
}
