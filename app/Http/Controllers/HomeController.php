<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompetitionPrice;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['Administrador', 'Invitado', 'Ventas']);
        $months = [
            ['name' => 'Enero', 'id' => '01'],
            ['name' => 'Febrero', 'id' => '02'],
            ['name' => 'Marzo', 'id' => '03'],
            ['name' => 'Abril', 'id' => '04'],
            ['name' => 'Mayo', 'id' => '05'],
            ['name' => 'Junio', 'id' => '06'],
            ['name' => 'Julio', 'id' => '07'],
            ['name' => 'Agosto', 'id' => '08'],
            ['name' => 'Septiembre', 'id' => '09'],
            ['name' => 'Octubre', 'id' => '10'],
            ['name' => 'Noviembre', 'id' => '11'],
            ['name' => 'Diciembre', 'id' => '12'],
        ];
        $days = [];
        for ($i = 1; $i <= date('d'); $i++) {
            array_push($days, $i);
        }
        $company = Company::all()->first();
        return view('dashboard', [
            'months' => $months,
            'actualMonth' => date('m'),
            'companies' => Company::all(),
            'days' => $days,
            'prices' => $company != null ? $this->getPrices($company->id, date('m')) : []
        ]);
    }
    // respuesta json precios por empresa
    public function getPricesJson(Request $request, $company_id, $month)
    {
        $request->user()->authorizeRoles(['Administrador', 'Invitado', 'Ventas']);
        return response()->json(['prices' => $this->getPrices($company_id, $month)]);
    }
    // precios por empresa
    private function getPrices($company_id, $month)
    {
        $prices = [];
        foreach (($company = Company::find($company_id))->terminals as $terminal) {
            /* $dataTerminal = CompetitionPrice::whereDate('created_at', '>=', date('Y') . '-' . date('m') . '-01')
                ->whereDate('created_at', '<=', now()->format('Y-m-d')) */
            $dataTerminal = CompetitionPrice::whereDate('created_at', '>=', '2020-' . $month . '-01')
                ->whereDate('created_at', '<=', '2020-' . $month . '-14')
                ->where([['terminal_id', $terminal->id], ['company_id', $company->id]])->get()->sortBy('created_at');
            $data['name'] = $terminal->name;
            $data['regular'] = [];
            $data['premium'] = [];
            $data['diesel'] = [];
            foreach ($dataTerminal as $product) {
                array_push($data['regular'], $product->regular);
                array_push($data['premium'], $product->premium);
                array_push($data['diesel'], $product->diesel);
            }
            array_push($prices, $data);
            $data = [];
        }
        return $prices;
    }
}
