<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Repositories\Activities;
use App\Terminal;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        return view('companies.index', ['companies' => Company::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        return view('companies.create', ['terminals' => Terminal::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $company = Company::create($request->all());
        $company->terminals()->attach($request->terminal_id);
        return redirect()->route('companies.index')->withStatus('Empresa registrada correctamente');
    }

    public function show(Request $request, $company)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $activities = new Activities();
        if ($company == 0) {
            return response()->json(['fees' => $activities->getFees()]);
        }
        return response()->json(['fees' => $activities->getFees($company)]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Company $company)
    {
        $request->user()->authorizeRoles(['Administrador']);
        return view('companies.edit', ['company' => $company, 'terminals' => Terminal::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, Company $company)
    {
        $request->user()->authorizeRoles(['Administrador']);
        if ($request->main == null)
            $request->merge(['main' => 0]);
        $company->update($request->except('active'));
        foreach ($company->terminals as $terminal) {
            if (!in_array($terminal->id, $request->terminal_id)) {
                $company->terminals()->detach($terminal->id);
            }
        }
        foreach ($request->terminal_id as $terminal_id) {
            if (!$company->terminals->contains($terminal_id)) {
                $company->terminals()->attach($terminal_id);
            }
        }
        return redirect()->route('companies.index')->withStatus('Se ha actualizado la empresa correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Company $company)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $company->delete();
        return redirect()->route('companies.index')->withStatus('Se ha dado de baja la empresa correctamente');
    }
}
