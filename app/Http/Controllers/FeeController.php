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
    // Dar de baja un fee
    public function destroy(Request $request, Fee $fit)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $fit->update(['active' => 0]);
        $fit->delete();
        return redirect()->route('fits.index')->withStatus(__('FEE dado de baja correctamente'));
    }
    // Método para obtener los fee, por terminal, empresa, precio base y/o fecha
    public function getFees(Request $request, $terminal, $company, $base, $date = null)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $pemex = false;
        if ($base != 0 && strcasecmp(Company::find($base)->name, 'pemex') == 0) {
            $pemex = true;
        }
        $query = [];
        $fees = [];
        $terminal != 0 ? array_push($query, ['terminal_id', $terminal]) : $query;
        $company != 0 ? array_push($query, ['company_id', $company]) : $query;
        $base != 0 ? array_push($query, ['base_id', $base]) : $query;
        if ($date != 'null') {
            $fee = count($query) > 0 ? Fee::where($query)->whereDate('created_at', $date)->get() : Fee::whereDate('created_at', $date)->get();
        } else {
            $fee = Fee::where($query)->get();
        }

        foreach ($fee as $f) {
            if ($f->active == 0)
                $f->delete();
        }

        foreach ($fee as $f) {
            $data['id'] = $f->id;
            $data['company'] = $f->terminals->name;
            $data['terminal'] = $f->companies->name;
            $data['base'] = $f->base_id != null ? $f->base->name : '';
            $data['regular_fee'] = $f->regular_fit;
            $data['premium_fee'] = $f->premium_fit;
            $data['diesel_fee'] = $f->diesel_fit;
            $data['date'] = $f->created_at->format('Y/m/d');
            array_push($fees, $data);
        }
        return response()->json(['fees' => $fees, 'pemex' => $pemex]);
    }
}
