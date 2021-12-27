<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Controllers\Controller;
use App\Order;
use App\Repositories\Activities;
use App\Repositories\Chartdata;
use Illuminate\Http\Request;

class GraficasController extends Controller
{
    // Total de transporte por empresa y mes
    public function totalTransporte($month = null)
    {
        $orders = $month ?
            Order::where('status_id', 2)->where('created_at', 'like', "%{$month}%")->with(['company', 'payments'])->get()
            : Order::where('status_id', 2)->whereYear('created_at', date('Y'))->with(['company', 'payments'])->get();
        $data = [];
        $totals = [];
        foreach ($orders as $order) {
            if ($order->name_freight) {
                $data["{$order->name_freight}"] = 0;
                $pagoAFletera = $order->invoice_shipper ? $order->invoice_shipper : $order->payments->sum('payment_freight');
                $data["{$order->name_freight}"] += $pagoAFletera;
            }
        }
        $names = [];
        foreach ($orders as $order) {
            if ($order->name_freight) {
                if (!in_array($order->name_freight, $names)) {
                    array_push($names, $order->name_freight);
                    array_push($totals, ['company' => $order->name_freight, 'total' => $data["{$order->name_freight}"]]);
                }
            }
        }
        return $totals;
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
            if (($orders = $company->orders()->where('status_id', 2)->whereYear('created_at', date('Y'))->with(['company', 'payments'])->get())->count() > 0) {
                $data['id'] = $company->id;
                $data['company'] = $company->alias;
                $data['total'] = 0;
                foreach ($orders as $order) {
                    $litrosDespachados = $order->dispatched_liters;
                    $cantidadFacturadaACliente = $order->amount ? $order->invoice + $order->invoice2 - $order->amount : $order->invoice + $order->invoice2;
                    $cantidadFacturadaPorValero = $order->invoicepayment + $order->invoicepayment2;
                    $pagoAFletera = $order->invoice_shipper ? $order->invoice_shipper : $order->payments->sum('payment_freight');
                    $utilidadGeneral = $cantidadFacturadaACliente - $cantidadFacturadaPorValero - $pagoAFletera;
                    $comisionista1 = $order->commission ?? 0 * $litrosDespachados;
                    $comisionista2 = $order->commission_two ?? 0 * $litrosDespachados;
                    $comisionista3 = $order->commission_three ?? 0 * $litrosDespachados;
                    $utilidadCliente = $utilidadGeneral - $comisionista1 - $comisionista2 - $comisionista3;
                    $data['total'] += $utilidadCliente;
                }
                $data['total'] = '$ ' . number_format($data['total'], 2);
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
            if (($orders = $company->orders()->where('status_id', 2)->whereYear('created_at', date('Y'))->with(['company', 'payments'])->get())->count() > 0) {
                $data['id'] = $company->id;
                $data['company'] = $company->alias;
                $data['total'] = 0;
                foreach ($orders as $order) {
                    $cantidadFacturadaACliente = $order->amount ? $order->invoice + $order->invoice2 - $order->amount : $order->invoice + $order->invoice2;
                    $cantidadFacturadaPorValero = $order->invoicepayment + $order->invoicepayment2;
                    $pagoAFletera = $order->invoice_shipper ? $order->invoice_shipper : $order->payments->sum('payment_freight');
                    $utilidadGeneral = $cantidadFacturadaACliente - $cantidadFacturadaPorValero - $pagoAFletera;
                    $data['total'] += $utilidadGeneral;
                }
                $data['total'] = '$ ' . number_format($data['total'], 2);
                array_push($companies, $data);
            }
        }
        return $companies;
    }
    // Total utilidad Guerrera
    public function utilidadGuerrera()
    {
        $months = new Activities();
        $orders = Order::where('status_id', 2)->whereYear('created_at', date('Y'))->with(['company', 'payments'])->get();
        $month = $orders->first()->created_at->format('Y-m');
        $data = [];
        $total = 0;
        foreach ($orders as $order) {
            if ($month != $order->created_at->format('Y-m')) {
                array_push($data, ["month" => $months->getMonths($month), 'total' => '$ ' .  number_format($total, 2)]);
                $month = $order->created_at->format('Y-m');
                $total = 0;
            }
            $litrosDespachados = $order->dispatched_liters;
            $cantidadFacturadaACliente = $order->amount ? $order->invoice + $order->invoice2 - $order->amount : $order->invoice + $order->invoice2;
            $cantidadFacturadaPorValero = $order->invoicepayment + $order->invoicepayment2;
            $pagoAFletera = $order->invoice_shipper ? $order->invoice_shipper : $order->payments->sum('payment_freight');
            $utilidadGeneral = $cantidadFacturadaACliente - $cantidadFacturadaPorValero - $pagoAFletera;
            $comisionista1 = $order->commission ?? 0 * $litrosDespachados;
            $comisionista2 = $order->commission_two ?? 0 * $litrosDespachados;
            $comisionista3 = $order->commission_three ?? 0 * $litrosDespachados;
            $utilidadCliente = $utilidadGeneral - $comisionista1 - $comisionista2 - $comisionista3;
            $utilidadGuerrera = ($utilidadCliente * 0.2);
            $total += $utilidadGuerrera;
        }
        array_push($data, ["month" => $months->getMonths($month), 'total' => '$ ' .  number_format($total, 2)]);
        return $data;
    }
    // Acumulado IVA por mes
    public function iva()
    {
        $months = new Activities();
        $orders = Order::where('status_id', 2)->whereYear('created_at', date('Y'))->with(['company', 'payments'])->get();
        $month = $orders->first()->created_at->format('Y-m');
        $data = [];
        $totalIva = 0;
        foreach ($orders as $order) {
            if ($month != $order->created_at->format('Y-m')) {
                array_push($data, ["month" => $months->getMonths($month), 'total' => '$ ' .  number_format($totalIva, 2)]);
                $month = $order->created_at->format('Y-m');
                $totalIva = 0;
            }
            $cantidadFacturadaACliente = $order->amount ? $order->invoice + $order->invoice2 - $order->amount : $order->invoice + $order->invoice2;
            $cantidadFacturadaPorValero = $order->invoicepayment + $order->invoicepayment2;
            $pagoAFletera = $order->invoice_shipper ? $order->invoice_shipper : $order->payments->sum('payment_freight');
            $utilidadGeneral = $cantidadFacturadaACliente - $cantidadFacturadaPorValero - $pagoAFletera;
            $litrosDespachados = $order->dispatched_liters;
            $comisionista1 = $order->commission ?? 0 * $litrosDespachados;
            $comisionista2 = $order->commission_two ?? 0 * $litrosDespachados;
            $utilidadMultioil = ($utilidadGeneral - $comisionista1 - $comisionista2) * 0.8;
            $utilidadMultioilSinIVA = $utilidadMultioil / 1.16;
            $iva = $utilidadMultioil - $utilidadMultioilSinIVA;
            $totalIva += $iva;
        }
        array_push($data, ["month" => $months->getMonths($month), 'total' => '$ ' .  number_format($totalIva, 2)]);
        return $data;
    }
    // Merma por cliente o por mes si este existe
    public function mermaPorClienteMes($month = null)
    {
        $companies = [];
        foreach (Company::where('active', 1)->with('orders')->get() as $company) {
            $orders = $month ?
                $company->orders()->where('dispatched', 'like', "%{$month}%")->where('status_id', 2)->get() :
                $company->orders->where('status_id', 2);
            if ($orders->count() > 0) {
                $data['id'] = $company->id;
                $data['company'] = $company->alias;
                $data['total'] = 0;
                foreach ($orders as $order) {
                    $data['total'] += $order->dispatched_liters - $order->root_liters ?? 0;
                }
                array_push($companies, $data);
            }
        }
        return $companies;
    }

    public function mouthLast($revers = 0)
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
        if ($revers) {
            $meses_hasta_el_actual = array_reverse($meses_hasta_el_actual);
            $array_meses_largos = array_reverse($array_meses_largos);
            $array_meses = array_reverse($array_meses);
        }
        array_push($combinacion,  $array_meses);
        array_push($combinacion,  $array_meses_largos);
        array_push($combinacion,  $meses_hasta_el_actual);
        return $combinacion;
    }
}
