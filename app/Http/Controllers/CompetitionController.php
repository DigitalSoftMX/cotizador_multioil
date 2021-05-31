<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Competition;
use App\Price;

class CompetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        return view('competidores.index', ['competicions' => Competition::all()]);
    }

    public function competencia_selec(Request $request, Competition $model, Price $price)
    {
        $request->user()->authorizeRoles(['Administrador']);

        $comeptidor_selecionado = $request['id'];
        $fecha = $request['fecha'];

        $precios = Price::where('competition_id', $comeptidor_selecionado)->where('created_at', 'like', '' . $fecha . '%')->get();
        $selecion = array('precios' => $precios);
        return json_encode($selecion);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $competicions = Competition::all();
        return view('competidores.create', compact('competicions'));
    }

    public function calendario_edit_pemex(Request $request, Price $price)
    {
        $terminal_seleciona = $request['idTerminal'];
        $fecha = $request['fecha'];
        $precio_r = $request['precio_r'];
        $precio_p = $request['precio_p'];
        $precio_d = $request['precio_d'];

        if ($terminal_seleciona == "") {
            $terminal_seleciona = "3";
        }

        if ($price::where('competition_id', $terminal_seleciona)->where('created_at', 'like', '' . $fecha . '%')->update(['precio_regular' => $precio_r, 'precio_premium' => $precio_p, 'precio_disel' => $precio_d])) {
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Price $price)
    {
        $request->user()->authorizeRoles(['Administrador']);
        //dd($request->all());
        $price->create($request->all());
        return redirect()->route('competencia.index')->withStatus(__('Precio agregado correctamente.'));
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
        $competicions = Competition::findOrFail($id);
        return view('competidores.edit', compact('competicions'));
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
        $request->user()->authorizeRoles(['Administrador']);
        $competition = Price::findorfail($id);
        $competition->update($request->all());
        return redirect()->route('competencia.index')->withStatus(__('Actualización correcta'));
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
