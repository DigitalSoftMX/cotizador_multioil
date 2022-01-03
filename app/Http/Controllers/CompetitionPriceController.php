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
        $year = CompetitionPrice::all()->sortBy('created_at')->first()->created_at->format('Y');
        return view('prices.index', ['companies' => Company::all(), 'year' => $year]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $year = CompetitionPrice::all()->sortBy('created_at')->first()->created_at->format('Y');
        return view('prices.create', [
            'terminals' => Terminal::all(),
            'companies' => Company::where('main', 0)->get(),
            'bases' => Company::where('main', 1)->get(),
            'year' => $year,
        ]);
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
            'base_id' => 'required|integer', 'terminal_id' => 'required|integer',
            'created_at' => 'required|date', 'companies' => 'required|array',
            'continue' => 'required|integer'
        ]);
        $request = $request->regular == null ? $request->merge(['regular' => 0]) : $request;
        $request = $request->premium == null ? $request->merge(['premium' => 0]) : $request;
        $request = $request->diesel == null ? $request->merge(['diesel' => 0]) : $request;
        $request->merge(['regular_sf' => $request->regular, 'premium_sf' => $request->premium, 'diesel_sf' => $request->diesel]);
        if ($request->regular == 0 && $request->premium == 0 && $request->diesel == 0)
            request()->validate(['prices' => 'required']);
        foreach ($request->companies as $fee) {
            $fit = Fee::find($fee);
            $request->merge([
                'terminal_id' => $fit->terminal_id,
                'regular' => $request->regular_sf + $fit->regular_fit,
                'premium' => $request->premium_sf + $fit->premium_fit,
                'diesel' => $request->diesel_sf + $fit->diesel_fit,
                'fee_id' => $fee
            ]);
            // existencia de un precio
            $price = CompetitionPrice::where([
                ['terminal_id', $request->terminal_id], ['company_id', $fit->company_id]
            ])->whereDate('created_at', $request->created_at)->first();
            if ($price != null) {
                $price->update($request->only(['regular', 'premium', 'diesel', 'regular_sf', 'premium_sf', 'diesel_sf', 'fee_id']));
            } else {
                CompetitionPrice::create($request->merge(['company_id' => $fit->company_id])->all());
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
        $year = CompetitionPrice::all()->sortBy('created_at')->first()->created_at->format('Y');
        return view('prices.edit', [
            'price' => $price,
            'terminals' => Terminal::all(),
            'companies' => Company::where('main', 0)->get(),
            'bases' => Company::where('main', 1)->get(),
            'year' => $year,
        ]);
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
            'base_id' => 'required|integer',
            'created_at' => 'required|date',
            'companies' => 'required|integer',
            'continue' => 'required|integer'
        ]);
        $request = $request->regular == null ? $request->merge(['regular' => 0]) : $request;
        $request = $request->premium == null ? $request->merge(['premium' => 0]) : $request;
        $request = $request->diesel == null ? $request->merge(['diesel' => 0]) : $request;
        $request->merge(['regular_sf' => $request->regular, 'premium_sf' => $request->premium, 'diesel_sf' => $request->diesel, 'fee_id' => $request->companies]);
        $fee = Fee::find($request->fee_id);
        $request->merge([
            'regular' => $request->regular + $fee->regular_fit,
            'premium' => $request->premium + $fee->premium_fit,
            'diesel' => $request->diesel + $fee->diesel_fit
        ]);
        $price->update($request->except(['company_id', 'terminal_id']));
        $oldPrice = CompetitionPrice::whereDate('created_at', $request->created_at)
            ->where([['company_id', $price->company_id], ['terminal_id', $price->terminal_id]])->first();
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
    public function getPrice(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador']);
        $price = false;
        $date = false;
        $fee = Fee::find($request->fee);
        $price = CompetitionPrice::where([['terminal_id', $fee->terminal_id], ['company_id', $fee->company_id]])->whereDate('created_at', $request->date)->exists();
        $date = CompetitionPrice::whereDate('created_at', $request->date)->exists();
        return response()->json(['price' => $price, 'date' => $date]);
    }
    // Metodo para obtener el ultimo precio por terminal y empresa
    public function getLastPrice(Request $request, $company, $terminal, $date = null)
    {
        $request->user()->authorizeRoles(['Administrador', 'Cliente']);
        $prices = $date ?
            CompetitionPrice::where([['company_id', $company], ['terminal_id', $terminal]])
            ->whereDate('created_at', $date)->get()->last()
            : CompetitionPrice::where([['company_id', $company], ['terminal_id', $terminal]])->get()->last();
        if ($date > now()->format('Y-m-d'))
            $prices = CompetitionPrice::where([['company_id', $company], ['terminal_id', $terminal]])->get()->last();
        return response()->json(['prices' => $prices]);
    }
}
