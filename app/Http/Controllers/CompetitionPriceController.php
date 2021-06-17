<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompetitionPrice;
use App\Fee;
use App\Http\Controllers\Controller;
use App\Repositories\Activities;
use App\Terminal;
use Illuminate\Http\Request;

class CompetitionPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        return view('prices.index', ['companies' => Company::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        return view('prices.create', ['terminals' => Terminal::all()]);
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
        request()->validate([
            'terminal_id' => 'required|integer',
            'continue' => 'required|integer'
        ]);
        $request = $request->created_at == null ? $request->merge(['created_at' => now()]) : $request;
        $request = $request->regular == null ? $request->merge(['regular' => 0]) : $request;
        $request = $request->regular == null ? $request->merge(['premium' => 0]) : $request;
        $request = $request->regular == null ? $request->merge(['diesel' => 0]) : $request;
        $regular = $request->regular;
        $premium = $request->premium;
        $diesel = $request->diesel;
        $terminal = Terminal::find($request->terminal_id);
        $companies = $request->pemex != null ? Company::where('id', 15)->get() : $terminal->companies->where('id', '!=', 15);
        foreach ($companies as $company) {
            if ($request->pemex == null) {
                $fee = Fee::where([['terminal_id', $request->terminal_id], ['company_id', $company->id]])->get()->last();
                $request->merge(['regular' => $fee != null ? $request->regular + $fee->regular_fit : $regular]);
                $request->merge(['premium' => $fee != null ? $request->premium + $fee->premium_fit : $premium]);
                $request->merge(['diesel' => $fee != null ? $request->diesel + $fee->diesel_fit : $diesel]);
            }
            CompetitionPrice::create($request->merge(['company_id' => $company->id])->all());
        }
        return $request->continue == 0 ? redirect()->back()->withStatus('Precio registrado correctamente.') : redirect()->route('prices.index')->withStatus('Precio registrado correctamente.');
    }

    public function show(Request $request, $price)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $activities = new Activities();
        if ($price == 0) {
            return response()->json(['prices' => $activities->getPrices()]);
        }
        return response()->json(['prices' => $activities->getPrices($price)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CompetitionPrice  $competitionPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, CompetitionPrice $price)
    {
        $request->user()->authorizeRoles(['Administrador']);
        return view('prices.edit', ['price' => $price, 'terminals' => Terminal::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CompetitionPrice  $competitionPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompetitionPrice $price)
    {
        $request->user()->authorizeRoles(['Administrador']);
        request()->validate([
            'company_id' => 'required|integer',
            'terminal_id' => 'required|integer',
            'created_at' => 'required|date',
            'continue' => 'required|integer'
        ]);
        $request = $request->regular == null ? $request->merge(['regular' => 0]) : $request;
        $request = $request->regular == null ? $request->merge(['premium' => 0]) : $request;
        $request = $request->regular == null ? $request->merge(['diesel' => 0]) : $request;
        $price->update($request->all());
        return $request->continue == 0 ? redirect()->back()->withStatus('Precio actualizado correctamente.') : redirect()->route('prices.index')->withStatus('Precio actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CompetitionPrice  $competitionPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompetitionPrice $competitionPrice)
    {
        //
    }
    // Metodo para obtener un precio por terminal, empresa y fecha
    public function getPrice(Request $request, $terminal, $company, $date)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $price = CompetitionPrice::whereDate('created_at', $date)->where([['company_id', $company], ['terminal_id', $terminal]])->first();
        return response()->json([
            'response' => $price != null ? true : false,
            'id' => $price != null ? $price->id : null,
            'regular' => $price != null ? $price->regular : null,
            'premium' => $price != null ? $price->premium : null,
            'diesel' => $price != null ? $price->diesel : null
        ]);
    }
    // Metodo para obtener el ultimo precio por terminal y empresa
    public function getLastPrice(Request $request, $company, $terminal)
    {
        $request->user()->authorizeRoles(['Administrador', 'Cliente']);
        $prices = CompetitionPrice::where([['company_id', $company], ['terminal_id', $terminal]])->get()->last();
        $fees = Fee::where([['company_id', $company], ['terminal_id', $terminal]])->get()->last();
        return response()->json(['prices' => $prices, 'fees' => $fees]);
    }
}
