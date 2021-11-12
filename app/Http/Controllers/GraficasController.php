<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class GraficasController extends Controller
{
    public function index()
    {
        $companies = [];
        $orders = Order::where('status_id', 2)->get();
        foreach ($orders as $order) {
            $data = $order->company_id;
            $data = $order->company->name;
            array_push($companies, $data);
            // return $order->payments->sum('payments_freight');
        }
        return $companies;
    }
}
