<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompetitionPrice;
use App\Repositories\Activities;
use App\Terminal;
use DateTime;
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
        $request->user()->authorizeRoles(['Administrador', 'Cliente', 'Ventas']);
        $activity = new Activities();
        $months = $activity->getMonths();
        $days = [];
        for ($i = 1; $i <= (int)date('d'); $i++) {
            array_push($days, $i);
        }
        $terminal = Terminal::all()->first();
        if (auth()->user()->company_id != null) {
            $prices = $terminal != null ? $this->getPrices($terminal->id, date('m'), auth()->user()->company_id) : [];
        } else {
            $prices = $terminal != null ? $this->getPrices($terminal->id, date('m')) : [];
        }
        return view('dashboard', [
            'months' => $months,
            'actualMonth' => date('m'),
            'terminals' => Terminal::all(),
            'days' => $days,
            'prices' => $prices,
            'pricesclient' => auth()->user()->roles->last()->id == 2 ? auth()->user()->company->prices->last() : ''
        ]);
    }
    // respuesta json precios por terminal
    public function getPricesJson(Request $request, $terminal_id, $month)
    {
        $request->user()->authorizeRoles(['Administrador', 'Cliente', 'Ventas']);
        $lastDay = date('d');
        if ($month != date('m')) {
            $lastDay = new DateTime(date('Y') . '-' . $month . '-01');
            $lastDay->modify('last day of this month');
            $lastDay = $lastDay->format('d');
        }
        // numero de dias del mes
        $days = [];
        for ($i = 1; $i <= (int)$lastDay; $i++) {
            array_push($days, $i);
        }
        return response()->json([
            'days' => $days,
            'prices' => $this->getPrices($terminal_id, $month, auth()->user()->company_id != null ? auth()->user()->company_id : null)
        ]);
    }
    // precios por empresa
    private function getPrices($terminal_id, $month, $company_id = null)
    {
        $start = date('Y') . '-' . $month . '-01';
        $lastDay = date('d');
        if ($month != date('m')) {
            $lastDay = new DateTime($start);
            $lastDay->modify('last day of this month');
            $lastDay = $lastDay->format('d');
        }
        $prices = [];
        if ($company_id != null) {
            $companies = Company::where('id', 2)->orWhere('id', $company_id)->get();
        } else {
            $companies = Terminal::find($terminal_id)->companies;
        }
        foreach ($companies as $company) {
            $dataCompany = CompetitionPrice::whereDate('created_at', '>=', $start)
                ->whereDate('created_at', '<=', date('Y') . '-' . $month . '-' . $lastDay)
                ->where([['terminal_id', $terminal_id], ['company_id', $company->id]])->get()->sortBy('created_at');
            $data['name'] = $company->name;
            $data['regular'] = [];
            $data['premium'] = [];
            $data['diesel'] = [];
            for ($i = 0; $i < (int)$lastDay; $i++) {
                array_push($data['regular'], ',');
                array_push($data['premium'], ',');
                array_push($data['diesel'], ',');
            }
            foreach ($dataCompany as $product) {
                $date = new DateTime($start);
                for ($i = 0; $i < (int)$lastDay; $i++) {
                    if ($product->created_at->format('Y-m-d') == $date->format('Y-m-d')) {
                        $data['regular'][$i] = $product->regular;
                        $data['premium'][$i] = $product->premium;
                        $data['diesel'][$i] = $product->diesel;
                    }
                    $date->modify('+1 day');
                }
            }
            array_push($prices, $data);
            $data = [];
        }
        return $prices;
    }
}
