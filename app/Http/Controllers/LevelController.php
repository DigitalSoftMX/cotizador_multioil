<?php

namespace App\Http\Controllers;

use App\Level;
use App\Http\Controllers\Controller;
use App\Terminal;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador', 'Cliente', 'Ventas']);
        return view(
            'levels.index',
            [
                'terminals' => Terminal::where([['latitude', '!=', null], ['longitude', '!=', null]])->get(),
                'pipa' => Level::where('truck_id', 1)->orderBy('kms', 'asc')->get(),
                'sencillo' => Level::where('truck_id', 2)->orderBy('kms', 'asc')->get(),
                'full' => Level::where('truck_id', 3)->orderBy('kms', 'asc')->get(),
                'levels' => Level::orderBy('kms', 'asc')->get()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        return view('levels.create', ['levels' => Level::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        request()->validate(['truck_id' => 'required|integer', 'kms' => 'required|numeric', 'price' => 'required|numeric']);
        Level::create($request->all());
        return redirect()->route('levels.create')->withStatus('Nivel kilómetro - precio agregado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Level $level)
    {
        $request->user()->authorizeRoles(['Administrador']);
        return view('levels.edit', ['level' => $level]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Level $level)
    {
        $request->user()->authorizeRoles(['Administrador']);
        request()->validate(['truck_id' => 'required|integer', 'kms' => 'required|numeric', 'price' => 'required|numeric']);
        $level->update($request->all());
        return redirect()->route('levels.create')->withStatus('Nivel actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Level $level)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $level->delete();
        return redirect()->route('levels.create')->withStatus('Nivel eliminado correctamente');
    }
}
