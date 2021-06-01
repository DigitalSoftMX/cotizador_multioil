<?php

namespace App\Http\Controllers;

use App\Terminal;
use Illuminate\Http\Request;
use App\Http\Requests\TerminalRequest;


class TerminalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        return view('terminals.index', ['terminals' => Terminal::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        return view('terminals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TerminalRequest $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        Terminal::create($request->merge(['status' => 1])->all());
        return redirect()->route('terminals.index')->withStatus(__('Terminal registrada correctamente'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Terminal $terminal)
    {
        $request->user()->authorizeRoles(['Administrador']);
        return view('terminals.edit', compact('terminal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TerminalRequest $request, Terminal $terminal)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $terminal->update($request->all());
        return redirect()->route('terminals.index')->withStatus(__('Terminal actualizada correctamente.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Terminal $terminal)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $terminal->delete();
        return redirect()->route('terminals.index')->withStatus(__('Terminal eliminada correctamente.'));
    }
}
