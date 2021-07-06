<?php

namespace App\Http\Controllers;

use App\Company;
use App\Fee;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeeRequest;
use App\Terminal;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        return view('fits.index', ['companies' => Company::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        return view('fits.create', ['terminals' => Terminal::all(), 'bases' => Company::where('main', 1)->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeeRequest $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        // return $request->all();
        Fee::create($request->all());
        return redirect()->route('fits.index')->withStatus(__('FEE registrado correctamente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fee  $fit
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Fee $fit)
    {
        $request->user()->authorizeRoles(['Administrador']);
        return view('fits.edit', ['fit' => $fit, 'terminals' => Terminal::all(), 'bases' => Company::where('main', 1)->get()]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fee  $fit
     * @return \Illuminate\Http\Response
     */
    public function update(FeeRequest $request, Fee $fit)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $fit->update($request->all());
        return redirect()->route('fits.index')->withStatus(__('FEE actualizado correctamente'));
    }
}
