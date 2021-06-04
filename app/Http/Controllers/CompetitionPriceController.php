<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompetitionPrice;
use App\Http\Controllers\Controller;
use App\Price;
use App\PriceEnergo;
use App\PriceHamse;
use App\PriceImpulsa;
use App\PricePolicon;
use App\PricePotesta;
use App\Repositories\Activities;
use App\Terminal;
use App\Valero;
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
        $activity = new Activities();
        // precios de pemex
        foreach (Price::all() as $price) {
            $name = $price->competition->nombre;
            $company = Company::where('name', 'like', "%{$name}%")->first()->id;
            $terminal = $price->competition->terminal_id;
            $data = $activity->fillDataPrices($company, $terminal, $price);
            CompetitionPrice::create($data);
            $price->delete();
        }
        // precios de valero
        foreach (Valero::all() as $valero) {
            $company = Company::where('name', 'like', '%valero%')->first()->id;
            $terminal = $valero->terminal_id;
            $data = $activity->fillDataPrices($company, $terminal, $valero);
            CompetitionPrice::create($data);
            $valero->delete();
        }
        // Precios de energo
        foreach (PriceEnergo::all() as $energo) {
            $name = $energo->energo->nombre;
            $company = Company::where('name', 'like', "%{$name}%")->first()->id;
            $terminal = $energo->energo->terminal_id;
            $data = $activity->fillDataPrices($company, $terminal, $energo);
            CompetitionPrice::create($data);
            $energo->delete();
        }
        // Precios de hamse
        foreach (PriceHamse::all() as $hamse) {
            $name = $hamse->hamse->nombre;
            $company = Company::where('name', 'like', "%{$name}%")->first()->id;
            $terminal = $hamse->hamse->terminal_id;
            $data = $activity->fillDataPrices($company, $terminal, $hamse);
            CompetitionPrice::create($data);
            $hamse->delete();
        }
        // Precios de impulsa
        foreach (PriceImpulsa::all() as $impulsa) {
            $name = $impulsa->impulsa->nombre;
            $company = Company::where('name', 'like', "%{$name}%")->first()->id;
            $terminal = $impulsa->impulsa->terminal_id;
            $data = $activity->fillDataPrices($company, $terminal, $impulsa);
            CompetitionPrice::create($data);
            $impulsa->delete();
        }
        // Precios de 
        foreach (PricePolicon::all() as $policon) {
            $name = $policon->policon->nombre;
            $company = Company::where('name', 'like', "%{$name}%")->first()->id;
            $terminal = $policon->policon->terminal_id;
            $data = $activity->fillDataPrices($company, $terminal, $policon);
            CompetitionPrice::create($data);
            $policon->delete();
        }
        // precios potesta
        foreach (PricePotesta::all() as $potesta) {
            $name = $potesta->potesta->nombre;
            $company = Company::where('name', 'like', "%{$name}%")->first()->id;
            $terminal = $potesta->potesta->terminal_id;
            $data = $activity->fillDataPrices($company, $terminal, $potesta);
            CompetitionPrice::create($data);
            $potesta->delete();
        }
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
        return view('prices.create', ['companies' => Company::all(), 'terminals' => Terminal::all()]);
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
            'company_id' => 'required|integer',
            'terminal_id' => 'required|integer',
            'continue' => 'required|integer'
        ]);
        $request = $request->create_at == null ? $request->merge(['created_at' => now()]) : $request;
        $request = $request->regular == null ? $request->merge(['regular' => 0]) : $request;
        $request = $request->regular == null ? $request->merge(['premium' => 0]) : $request;
        $request = $request->regular == null ? $request->merge(['diesel' => 0]) : $request;
        CompetitionPrice::create($request->all());
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
        return view('prices.edit', ['price' => $price, 'companies' => Company::all(), 'terminals' => Terminal::all()]);
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
}
