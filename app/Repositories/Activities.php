<?php

namespace App\Repositories;

use App\Company;
use App\CompetitionPrice;
use App\Order;
use App\Terminal;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Activities
{
    // obteniendo los fees dependiendo la empresa
    public function getFees($company_id = null)
    {
        $fees = array();
        foreach (Terminal::all() as $terminal) {
            if ($company_id == null) {
                foreach (Company::all() as $company) {
                    $fee = $terminal->fits->where('company_id', $company->id)->last();
                    $fees = $fee != null ? $this->dataFees($fee, $fees) : $fees;
                }
            } else {
                $fee = $terminal->fits->where('company_id', $company_id)->last();
                $fees = $fee != null ? $this->dataFees($fee, $fees) : $fees;
            }
        }
        return $fees;
    }
    // llenado de fees
    private function dataFees($fee, $fees)
    {
        $data['id'] = $fee->id;
        $data['terminal'] = $fee->terminals->name;
        $data['company'] = $fee->companies->name;
        $data['base'] = $fee->base_id != null ? $fee->base->name : '';
        $data['regular_fit'] = '$ ' . $fee->regular_fit;
        $data['premium_fit'] = '$ ' . $fee->premium_fit;
        $data['diesel_fit'] = '$ ' . $fee->diesel_fit;
        $data['created_at'] = $fee->created_at->format('Y/m/d');
        array_push($fees, $data);
        return $fees;
    }
    // obteniendo los rpecios por empresa y fecha
    public function getPrices($company_id, $date)
    {
        $prices = array();
        foreach (Terminal::all() as $terminal) {
            if ($company_id == 0) {
                foreach (Company::all() as $company) {
                    $price = $date == 0 ?
                        $terminal->prices->where('company_id', $company->id)->last() :
                        CompetitionPrice::where([['company_id', $company->id], ['terminal_id', $terminal->id]])->whereDate('created_at', $date)->first();
                    $prices = $price != null ? $this->dataPrices($price, $prices) : $prices;
                }
            } else {
                $price = $date == 0 ?
                    $terminal->prices->where('company_id', $company_id)->last() :
                    CompetitionPrice::where([['company_id', $company_id], ['terminal_id', $terminal->id]])->whereDate('created_at', $date)->first();
                $prices = $price != null ? $this->dataPrices($price, $prices) : $prices;
            }
        }
        return $prices;
    }
    // Registro de pedidos
    public function register($request, $product)
    {
        $data = [
            'company_id' => $request['company_id'],
            'terminal_id'  => $request['terminal_id'],
            'freight' => $request['freight'],
            'price' => $request["price_$product"],
            'liters' => $request["liters_$product"],
            'total' => $request["total_$product"],
            'date' => $request['date'],
            'statud_id' => 1,
        ];
        if ($product == 'r')
            $data['product'] = 'regular';
        if ($product == 'p')
            $data['product'] = 'premium';
        if ($product == 'd')
            $data['product'] = 'diesel';
        if (isset($request['secure'])) {
            $data['secure'] = $request['secure'] == 0 ? 0 : 1;
        }
        Order::create($data);
    }
    // Metodo para validar pdf y xml
    public function saveFile($request, $invoice, $file)
    {
        if ($request->file("file_$file")) {
            if (File::exists(public_path() . $invoice->$file)) {
                File::delete(public_path() . $invoice->$file);
            }
            $save = $request->file("file_$file")->store('public' . '/orders/' . $invoice->id);
            $invoice->update([$file => Storage::url($save)]);
        }
    }
    // lista de meses en español
    public function getMonths()
    {
        return [
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
    }
    // llenado de precios
    private function dataPrices($price, $prices)
    {
        $data['id'] = $price->id;
        $data['terminal'] = $price->terminal->name;
        $data['company'] = $price->company->name;
        $data['regular'] = '$ ' . $price->regular;
        $data['premium'] = '$ ' . $price->premium;
        $data['diesel'] = '$ ' . $price->diesel;
        $data['created_at'] = $price->created_at->format('Y/m/d');
        array_push($prices, $data);
        return $prices;
    }
}
