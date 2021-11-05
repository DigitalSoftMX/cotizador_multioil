<?php

namespace App\Http\Controllers;

use App\Exports\PedidosExport;
use App\Pedido;
use App\Company;
use App\Events\EmailMultioil;
use App\Terminal;
use App\Http\Controllers\Controller;
use App\Http\Requests\PedidoRequest;
use Exception;
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
        if (auth()->user()->company_id != null)
            return view("Pedidos.index", ['terminals' => Terminal::all()], ['company' => auth()->user()->company]);
        return view("Pedidos.index", ['terminals' => Terminal::all()], ['companies' => Company::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PedidoRequest $request)
    {
        if (auth()->user()->roles->first()->id == 1)
            request()->validate(['company_id' => 'required|integer',]);
        if (auth()->user()->roles->first()->id == 2)
            $request->merge(['company_id' => auth()->user()->company_id]);
        $pedido = Pedido::create($request->all());
        try {
            event(new EmailMultioil($pedido, 4));
        } catch (Exception $th) {
        }
        return redirect()->back()->withStatus('Pedido semanal realizado correctamente');
    }

    public function downloadExcel(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador', 'Cliente']);
        return Excel::download(new PedidosExport, 'confirmacion_pedidos-semanales.xlsx');
    }
    public function export()
    {
        return view('exports.semanlorders', ['Pedidos' => Pedido::all()]);
    }
}
