<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompetitionPrice;
use App\Repositories\Activities;
use App\Terminal;
use App\Order;
use App\Payment;
use DateTime;
use Illuminate\Http\Request;
use DatePeriod;
use DateInterval;

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
        for ($i = 1; $i <= (int)date('d', strtotime(now() . "+ 1 day")); $i++) {
            array_push($days, $i);
        }
        $pricesClient = null;
        $terminal = Terminal::all()->first();
        if (auth()->user()->company_id != null) {
            $prices = $terminal != null ? $this->getPrices($terminal->id, date('m'), auth()->user()->company_id) : [];
            $pricesClient = auth()->user()->company->prices->where('terminal_id', $terminal->id)->sortByDesc('created_at')->first();
        } else {
            $prices = $terminal != null ? $this->getPrices($terminal->id, date('m')) : [];
        }
        //return $prices;
        return view('dashboard', [
            'months' => $months,
            'actualMonth' => date('m'),
            'terminals' => Terminal::all(),
            'days' => $days,
            'prices' => $prices,
            'pricesclient' => $pricesClient,
            'totalOrders' => Order::where('status_id', 2)->count(),
            'totalCompanys' => Company::count(),
            'totalLiters' => Order::where([['status_id', 2]])->sum('dispatched_liters'),
            'totalMoney' => Order::where([['status_id', 2]])->sum('total')
        ]);
    }
    // respuesta json precios por terminal
    public function getPricesJson(Request $request, $terminal_id, $month)
    {
        $request->user()->authorizeRoles(['Administrador', 'Cliente', 'Ventas']);
        $lastDay = date('d', strtotime(now() . "+ 1 day"));
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
        if ($month != date('m')) {
            $lastDay = new DateTime(date('Y') . '-' . $month . '-01');
            $lastDay->modify('last day of this month');
            $lastDay = date("d", strtotime($lastDay->format('Y-m-d') . "+ 1 days"));
            array_push($days, (int)$lastDay);
        }
        $pricesClient = null;
        if (auth()->user()->company_id != null)
            $pricesClient = auth()->user()->company->prices->where('terminal_id', $terminal_id)->last();
        return response()->json([
            'days' => $days,
            'prices' => $this->getPrices($terminal_id, $month, auth()->user()->company_id != null ? auth()->user()->company_id : null),
            'pricesclient' => $pricesClient
        ]);
    }
    // precios por empresa
    private function getPrices($terminal_id, $month, $company_id = null)
    {
        $pemex = Company::where('name', 'like', '%pemex%')->first();
        $start = date('Y') . '-' . $month . '-01';
        $lastDay = date('d');
        if ($month != date('m')) {
            $lastDay = new DateTime($start);
            $lastDay->modify('last day of this month');
            $lastDay = $lastDay->format('d');
        }
        $prices = [];
        if (($user = auth()->user())->roles->first()->id != 3) {
            if ($company_id != null) {
                $companies = Company::where('id', $pemex->id)->orWhere('id', $company_id)->get();
            } else {
                $companies = Terminal::find($terminal_id)->companies;
            }
        } else {
            $companies = $user->companies;
            $companies->prepend($pemex);
        }
        foreach ($companies as $company) {
            $dataCompany = CompetitionPrice::whereDate('created_at', '>=', $start)
                ->whereDate('created_at', '<=', date('Y') . '-' . $month . '-' . $lastDay)
                ->where([['terminal_id', $terminal_id], ['company_id', $company->id]])->get()->sortBy('created_at');
            $data['id'] = $company->id;
            $data['name'] = $company->name;
            $data['color'] = $company->color;
            $data['alias'] = $company->alias;
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
        //dd($prices);
        return $prices;
    }

    private function monthsToThePresent()
    {
        // array meses en español
        $array_meses_espanol = [
            "Jan" => "Enero",
            "Feb" => "Febrero",
            "Mar" => "Marzo",
            "Apr" => "Abril",
            "May" => "Mayo",
            "Jun" => "Junio",
            "Jul" => "Julio",
            "Aug" => "Agosto",
            "Sep" => "Septiembre",
            "Oct" => "Octubre",
            "Nov" => "Noviembre",
            "Dec" => "Diciembre"
        ];

        $array_meses_espanol_corto = [
            "Jan" => "Ene",
            "Feb" => "Feb",
            "Mar" => "Mar",
            "Apr" => "Abr",
            "May" => "May",
            "Jun" => "Jun",
            "Jul" => "Jul",
            "Aug" => "Ago",
            "Sep" => "Sep",
            "Oct" => "Oct",
            "Nov" => "Nov",
            "Dec" => "Dic"
        ];
        // array para los meses
        $array_meses = [];
        // array para los meses
        $array_meses_largos = [];
        $meses_hasta_el_actual = [];

        $combinacion = [];
        //for para llenar el array con los meses hasta el actual
        for ($i = 1; $i <= 11; $i++) {
            array_push($meses_hasta_el_actual, date("Y-m", mktime(0, 0, 0, date("m") - $i, 28, date("Y"))));
            array_push($array_meses, $array_meses_espanol_corto[strval(date("M", mktime(0, 0, 0, date("m") - $i, 28, date("Y"))))]);
            array_push($array_meses_largos, $array_meses_espanol[strval(date("M", mktime(0, 0, 0, date("m") - $i, 28, date("Y"))))]);
        }

        array_unshift($meses_hasta_el_actual, date("Y-m", mktime(0, 0, 0, date("m"), 28, date("Y"))));
        array_unshift($array_meses,  $array_meses_espanol_corto[strval(date("M", mktime(0, 0, 0, date("m"), 28, date("Y"))))]);
        array_unshift($array_meses_largos,  $array_meses_espanol[strval(date("M", mktime(0, 0, 0, date("m"), 28, date("Y"))))]);

        // revertimos el orden del array
        $meses_hasta_el_actual = array_reverse($meses_hasta_el_actual);
        $array_meses = array_reverse($array_meses);
        array_push($combinacion,  $array_meses);
        array_push($combinacion,  $meses_hasta_el_actual);
        return $combinacion;
    }

    public function monthsToThePresentLiters()
    {
        $meses =  $this->monthsToThePresent();
        // array ultimos 12 meses de todas las estaciones
        $liters_mouths = [];
        $result = [];
        // ordenes
        for ($mes = 0; $mes <= 11; $mes++) {
            array_push($liters_mouths, Order::where([['created_at', 'like', '%' . $meses[1][$mes] . '%'], ['status_id', 2]])->sum('dispatched_liters'));
        }

        array_push($result, $liters_mouths);
        array_push($result, $meses[0]);
        return $result;
    }


    public function monthsDaysProduct(Request $request)
    {
        $meses =  $this->monthsToThePresent();
        $liters_mouths_regular = [];
        $liters_mouths_premium = [];
        $liters_mouths_diesel = [];
        $result = [];
        $days = [];
        $temp_day = '01';

        if ($request->days == 0) {

            for ($day = 1; $day <= date('t', strtotime($meses[1][11])); $day++) {
                if ($day < 10) {
                    $temp_day = '0' . $day;
                } else {
                    $temp_day = $day;
                }
                array_push($liters_mouths_regular, Order::where([['created_at', 'like', '%' . $meses[1][11] . '-' . $temp_day . '%'], ['status_id', 2], ['product', 'regular']])->sum('dispatched_liters'));
                array_push($liters_mouths_premium, Order::where([['created_at', 'like', '%' . $meses[1][11] . '-' . $temp_day . '%'], ['status_id', 2], ['product', 'premium']])->sum('dispatched_liters'));
                array_push($liters_mouths_diesel, Order::where([['created_at', 'like', '%' . $meses[1][11] . '-' . $temp_day . '%'], ['status_id', 2], ['product', 'diesel']])->sum('dispatched_liters'));
                array_push($days, $day);
            }
            array_push($result, $liters_mouths_regular);
            array_push($result, $liters_mouths_premium);
            array_push($result, $liters_mouths_diesel);
            array_push($result, $days);
            return $result;
        } else if ($request->days == 1) {

            for ($mes = 0; $mes <= 11; $mes++) {
                array_push($liters_mouths_regular, Order::where([['created_at', 'like', '%' . $meses[1][$mes] . '%'], ['status_id', 2], ['product', 'regular']])->sum('dispatched_liters'));
                array_push($liters_mouths_premium, Order::where([['created_at', 'like', '%' . $meses[1][$mes] . '%'], ['status_id', 2], ['product', 'premium']])->sum('dispatched_liters'));
                array_push($liters_mouths_diesel, Order::where([['created_at', 'like', '%' . $meses[1][$mes] . '%'], ['status_id', 2], ['product', 'diesel']])->sum('dispatched_liters'));
            }


            array_push($result, $liters_mouths_regular);
            array_push($result, $liters_mouths_premium);
            array_push($result, $liters_mouths_diesel);

            array_push($result, $meses[0]);
            return $result;
        } else if ($request->days == 2) {
            $begin = new DateTime($request->min);
            $end = new DateTime($request->max);
            $end = $end->modify('+1 day');

            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval, $end);
            //dd($daterange);

            foreach ($daterange as $date) {
                array_push($liters_mouths_regular, Order::where([['created_at', 'like', '%' . $date->format("Y-m-d") . '%'], ['status_id', 2], ['product', 'regular'], ['company_id', $request->id]])->sum('dispatched_liters'));
                array_push($liters_mouths_premium, Order::where([['created_at', 'like', '%' . $date->format("Y-m-d") . '%'], ['status_id', 2], ['product', 'premium'], ['company_id', $request->id]])->sum('dispatched_liters'));
                array_push($liters_mouths_diesel, Order::where([['created_at', 'like', '%' . $date->format("Y-m-d") . '%'], ['status_id', 2], ['product', 'diesel'], ['company_id', $request->id]])->sum('dispatched_liters'));
                //echo $date->format("Y-m-d") . "<br>";
                array_push($days,  $date->format("d"));
            }

            array_push($result, $liters_mouths_regular);
            array_push($result, $liters_mouths_premium);
            array_push($result, $liters_mouths_diesel);

            array_push($result, $days);

            return $result;
        } else if ($request->days == 3) {
            $begin = new DateTime($request->min);
            $end = new DateTime($request->max);
            $end = $end->modify('+1 day');

            $interval = new DateInterval('P1M');
            $daterange = new DatePeriod($begin, $interval, $end);

            foreach ($daterange as $date) {
                array_push($liters_mouths_regular, Order::where([['created_at', 'like', '%' . $date->format("Y-m") . '%'], ['status_id', 2], ['product', 'regular'], ['company_id', $request->id]])->sum('dispatched_liters'));
                array_push($liters_mouths_premium, Order::where([['created_at', 'like', '%' . $date->format("Y-m") . '%'], ['status_id', 2], ['product', 'premium'], ['company_id', $request->id]])->sum('dispatched_liters'));
                array_push($liters_mouths_diesel, Order::where([['created_at', 'like', '%' . $date->format("Y-m") . '%'], ['status_id', 2], ['product', 'diesel'], ['company_id', $request->id]])->sum('dispatched_liters'));
                //echo $date->format("Y-m-d") . "<br>";
                array_push($days,  $date->format("M"));
            }

            array_push($result, $liters_mouths_regular);
            array_push($result, $liters_mouths_premium);
            array_push($result, $liters_mouths_diesel);

            array_push($result, $days);

            return $result;
        } else if ($request->days == 4) {
            $begin = new DateTime($request->min);
            $end = new DateTime($request->max);
            $end = $end->modify('+0 day');

            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval, $end);

            foreach ($daterange as $date) {
                array_push($liters_mouths_regular, Payment::where([['created_at', 'like', '%' . $date->format("Y-m-d") . '%']])->sum('payment_freight'));

                array_push($days,  $date->format("d"));
            }

            array_push($result, $liters_mouths_regular);


            array_push($result, $days);

            return $result;
        }
    }
}
