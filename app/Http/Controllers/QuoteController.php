<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\Terminal;
use App\Fit;
use App\Discount;
use App\Competition;
use App\Valero;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        return view('quote.index', ['terminals' => Terminal::all()]);
    }


    public function cotizador_sele(Request $request, Fit $fit_model)
    {
        $terminal_seleciona = $request['terminal'];
        if ($terminal_seleciona == "") {
            $terminal_seleciona = "3";
        }
        $fits = $fit_model::where('terminal_id', $request['terminal'])->get()->last();
        $competitions = Competition::where('terminal_id', $terminal_seleciona)->get()->last();
        $precios = $competitions->prices[count($competitions->prices) - 1];
        $selecion = array('precios' => $precios, 'fits' => $fits);
        return json_encode($selecion);
    }

    public function calendario_edit(Request $request, Valero $valero)
    {
        $terminal_seleciona = $request['idTerminal'];
        $fecha = $request['fecha'];
        $precio_r = $request['precio_r'];
        $precio_p = $request['precio_p'];
        $precio_d = $request['precio_d'];

        if ($terminal_seleciona == "") {
            $terminal_seleciona = "3";
        }

        if ($valero::where('terminal_id', $terminal_seleciona)->where('created_at', 'like', '' . $fecha . '%')->update(['precio_regular' => $precio_r, 'precio_premium' => $precio_p, 'precio_disel' => $precio_d])) {
            $mensaje = 'Precios actualizados correctamente.';
            $color = 'success';
        } else {
            $mensaje = 'Error al actualizar los precios.';
            $color = 'danger';
        }

        $selecion = array('mensaje' => $mensaje, 'color' => $color);
        return json_encode($selecion);
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
    public function store(Request $request, Valero $valero)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $valero->create($request->all());
        return redirect()->route('cotizador.index')->withStatus(__('Precio agregado correctamente.'));
    }


    public function calendario_selec(Request $request, Terminal $model)
    {
        $terminal_seleciona = $request['terminal'];
        $fecha = $request['fecha'];
        $precios = Valero::where('terminal_id', $terminal_seleciona)->where('created_at', 'like', '' . $fecha . '%')->get();
        $selecion = array('precios' => $precios);
        return json_encode($selecion);
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
}
