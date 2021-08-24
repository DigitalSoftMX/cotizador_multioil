<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Order;
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
        return view('companies.index', ['companies' => Company::where('active', 1)->get()]);
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
        $company->update(['active' => 0]);
        return redirect()->route('companies.index')->withStatus('Se ha dado de baja la empresa correctamente');
    }
    // Estado de cuenta de la empresa
    public function getshopping(Request $request, Company $company)
    {
        $request->user()->authorizeRoles(['Administrador', 'Cliente']);
        $months = new Activities();
        return view('companies.state', [
            'months' => $months->getMonths(),
            'company' => $company,
            'activePage' => auth()->user()->roles->first()->id == 2 ? 'Estado de cuenta' : 'Empresas'
        ]);
    }
    // Método para obtener las ventas de un mes
    public function getshoppings(Request $request, $company, $month)
    {
        $request->user()->authorizeRoles(['Administrador', 'Cliente']);
        $total = 0;
        $sales = [];
        foreach (Order::where([['status_id', 2], ['company_id', $company]])->whereMonth('dispatched', $month)->get() as $order) {
            $data['date'] = $order->dispatched != null ? date('d/m/Y', strtotime($order->dispatched)) : '-';
            $data['cfdi'] = $order->CFDI;
            $data['product'] = strtoupper($order->product);
            $data['liters'] = number_format($order->liters, 2);
            $data['invoice'] = '$' . number_format($order->invoice, 2);
            $data['payment'] = '$' . number_format($order->payments->sum('payment_guerrera'), 2);
            $data['balance'] = '$' . number_format($t = ($order->payments->sum('payment_guerrera') - $order->invoice), 2);
            array_push($sales, $data);
            $total += $t;
        }
        return response()->json([
            'sales' => $sales,
            'total' => '$' . number_format($total, 2)
        ]);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showClientChart(Request $request, $id)
    {
        return view('companies.show',['company_id' => $id,]);
    }
}
