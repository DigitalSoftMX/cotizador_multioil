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
        return view('prices.create', ['terminals' => Terminal::all(), 'bases' => Company::where('main', 1)->get()]);
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
            'base_id' => 'required|integer',
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
            $price = CompetitionPrice::where([['terminal_id', $terminal->id], ['company_id', $company->id]])->whereDate('created_at', $request->created_at)->first();
            if ($price != null) {
                $price->update($request->only(['regular', 'premium', 'diesel']));
            } else {
                CompetitionPrice::create($request->merge(['company_id' => $company->id])->all());
            }
        }
        return $request->continue == 0 ? redirect()->back()->withStatus('Precio registrado correctamente.') : redirect()->route('prices.index')->withStatus('Precio registrado correctamente.');
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
        return view('prices.edit', ['price' => $price, 'terminals' => Terminal::all(), 'companies' => Company::all()]);
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
        $fee = Fee::where([['terminal_id', $request->terminal_id], ['company_id', $request->company_id]])->get()->last();
        $request->merge(['regular' => $fee != null ? $request->regular + $fee->regular_fit : $request->regular + 0]);
        $request->merge(['premium' => $fee != null ? $request->premium + $fee->premium_fit : $request->premium + 0]);
        $request->merge(['diesel' => $fee != null ? $request->diesel + $fee->diesel_fit : $request->diesel + 0]);
        $price->update($request->all());
        $oldPrice = CompetitionPrice::whereDate('created_at', $request->created_at)
            ->where([['company_id', $request->company_id], ['terminal_id', $request->terminal_id]])->first();
        if ($oldPrice->id != $price->id) {
            $oldPrice->delete();
        }
        return $request->continue == 0 ? redirect()->back()->withStatus('Precio actualizado correctamente.') : redirect()->route('prices.index')->withStatus('Precio actualizado correctamente.');
    }
    // Método para obtener todos los precios por empresa y fecha (opcional)
    public function getPrices(Request $request, $company, $date = 0)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $activities = new Activities();
        return response()->json([
            'prices' => $activities->getPrices($company, $date)
        ]);
    }
    // Metodo para obtener un precio por terminal, empresa pemex y fecha
    public function getPrice(Request $request, $pemex, $terminal, $date)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $price = CompetitionPrice::where([['terminal_id', $terminal], ['company_id', $pemex == 0 ? '!=' : '=', 15]])->whereDate('created_at', $date)->exists();
        return response()->json(['price' => $price]);
    }
    // Metodo para obtener el ultimo precio por terminal y empresa
    public function getLastPrice(Request $request, $company, $terminal)
    {
        $request->user()->authorizeRoles(['Administrador', 'Cliente']);
        $prices = CompetitionPrice::where([['company_id', $company], ['terminal_id', $terminal]])->get()->last();
        return response()->json(['prices' => $prices]);
    }
}
