<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Controllers\Controller;
use App\Repositories\Activities;
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
        return view('companies.create');
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
        request()->validate(['name' => 'required|min:3']);
        Company::create($request->only('name'));
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
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $request->user()->authorizeRoles(['Administrador']);
        request()->validate(['name' => 'required|min:3']);
        $company->update($request->only(['name']));
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
