<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Controllers\Controller;
use App\Repositories\Chartdata;
use Exception;
use Illuminate\Http\Request;

class GraficasController extends Controller
{
    // Total de transporte por empresa y mes
    public function totalTransporte($month = null)
    {
        $chart = new Chartdata();
        return $chart->getDataOrder('payment_freight', $month);
    }
    // Total de transporte por Cliente Guerrera y mes
    public function totalClienteGuerrera($month = null)
    {
        $chart = new Chartdata();
        return $chart->getDataOrder('payment_guerrera', $month);
    }
    // Total de transporte por Factura Valero - Guerrera y mes
    public function totalValeroGuerrera($month = null)
    {
        $chart = new Chartdata();
        return $chart->getDataOrder('payment_g_valero', $month);
    }
    // Total de utilidad por cliente
    public function utilidadCliente()
    {
        $companies = [];
        foreach (Company::where('active', 1)->with('orders')->get() as $company) {
            if (($orders = $company->orders->where('status_id', 2))->count() > 0) {
                $total = 0;
                $count = 0;
                $data['id'] = $company->id;
                $data['company'] = $company->alias;
                $data['total'] = 0;
                foreach ($orders as $order) {
                    try {
                        $diferenciaPrecio = $order->sale_price - $order->price;
                        $total += (($diferenciaPrecio * $order->dispatched_liters) / ($order->sale_price * $order->dispatched_liters)) * 100;
                        $count++;
                    } catch (Exception $th) {
                    }
                }
                $data['total'] = $total / $count;
                $data['total'] = number_format($data['total'], 2);
                array_push($companies, $data);
            }
        }
        return $companies;
    }
    // Total de utilidad General
    public function utilidadGeneral()
    {
        $companies = [];
        foreach (Company::where('active', 1)->with('orders')->get() as $company) {
            if (($orders = $company->orders->where('status_id', 2))->count() > 0) {
                $data['id'] = $company->id;
                $data['company'] = $company->alias;
                $data['total'] = 0;
                foreach ($orders as $order) {
                    $diferenciaPrecio = $order->sale_price - $order->price;
                    $pagoFletera = $order->invoice_shipper ? $order->invoice_shipper : $order->payments->sum('payment_freight');
                    $data['total'] += ($diferenciaPrecio * $order->dispatched_liters - $pagoFletera);
                }
                $data['total'] = number_format($data['total'], 2);
                array_push($companies, $data);
            }
        }
        return $companies;
    }
    // Total utilidad Guerrera
    public function utilidadGuerrera()
    {
        $companies = [];
        foreach (Company::where('active', 1)->with('orders')->get() as $company) {
            if (($orders = $company->orders->where('status_id', 2))->count() > 0) {
                $data['id'] = $company->id;
                $data['company'] = $company->alias;
                $data['total'] = 0;
                foreach ($orders as $order) {
                    $diferenciaPrecio = $order->sale_price - $order->price;
                    $pagoFletera = $order->invoice_shipper ? $order->invoice_shipper : $order->payments->sum('payment_freight');
                    $comision = ($diferenciaPrecio * $order->dispatched_liters - $pagoFletera);
                    $utilidadComisionista1 = $order->commission ? $order->commission * $order->dispatched_liters : 0;
                    $utilidadComisionista2 = $order->commission_two ? $order->commission_two * $order->dispatched_liters : 0;
                    $data['total'] += ($comision - $utilidadComisionista1 - $utilidadComisionista2) * 0.2;
                }
                $data['total'] = number_format($data['total'], 2);
                array_push($companies, $data);
            }
        }
        return $companies;
    }
    // Acumulado IVA por mes
    public function ivaPorMes()
    {
        $companies = [];
        foreach (Company::where('active', 1)->with('orders')->get() as $company) {
            if (($orders = $company->orders->where('status_id', 2))->count() > 0) {
                $data['id'] = $company->id;
                $data['company'] = $company->alias;
                $data['total'] = 0;
                foreach ($orders as $order) {
                    $diferenciaPrecio = $order->sale_price - $order->price;
                    $pagoFletera = $order->invoice_shipper ? $order->invoice_shipper : $order->payments->sum('payment_freight');
                    $comision = ($diferenciaPrecio * $order->dispatched_liters - $pagoFletera);
                    $utilidadComisionista1 = $order->commission ? $order->commission * $order->dispatched_liters : 0;
                    $utilidadComisionista2 = $order->commission_two ? $order->commission_two * $order->dispatched_liters : 0;
                    $utilidadMultioil = ($comision - $utilidadComisionista1 - $utilidadComisionista2) * 0.8;
                    $utilidadMultioilSinIVA = $utilidadMultioil / 1.16;
                    $data['total'] += ($utilidadMultioilSinIVA * 0.2);
                }
                $data['total'] = number_format($data['total'], 2);
                array_push($companies, $data);
            }
        }
        return $companies;
    }
    // Merma por cliente o por mes si este existe
    public function mermaPorClienteMes($month = null)
    {
        $companies = [];
        foreach (Company::where('active', 1)->with('orders')->get() as $company) {
            $orders = $month ?
                $orders = $company->orders()->whereYear('created_at', date('Y'))
                ->whereMonth('created_at', "{$month}")->where('status_id', 2)->get() :
                $company->orders->where('status_id', 2);
            if ($orders->count() > 0) {
                $data['id'] = $company->id;
                $data['company'] = $company->alias;
                $data['total'] = 0;
                foreach ($orders as $order) {
                    $data['total'] += ($order->root_liters ? $order->dispatched_liters - $order->root_liters : 0);
                }
                $data['total'] = number_format($data['total'], 2);
            }
            array_push($companies, $data);
        }
        return $companies;
    }
}
