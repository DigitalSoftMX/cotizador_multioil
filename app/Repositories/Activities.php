<?php

namespace App\Repositories;

use App\Company;
use App\CompetitionPrice;
use App\Terminal;

class Activities
{
    // copiando la tabla fits a fees
    public function fillData($fit, $company = null)
    {
        $data = [
            'terminal_id' => $fit->terminal_id,
            'commission' => $fit->comision,
            'regular_fit' => $fit->regular_fit,
            'premium_fit' => $fit->premium_fit,
            'diesel_fit' => $fit->disel_fit,
            'created_at' => $fit->created_at,
            'updated_at' => $fit->updated_at
        ];
        $data['company_id'] = $company;
        return $data;
    }
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
        $data['terminal'] = $fee->terminals->name;
        $data['company'] = $fee->companies->name;
        $data['commission'] = '$ ' . $fee->commission;
        $data['regular_fit'] = '$ ' . $fee->regular_fit;
        $data['premium_fit'] = '$ ' . $fee->premium_fit;
        $data['diesel_fit'] = '$ ' . $fee->diesel_fit;
        $data['created_at'] = $fee->created_at->format('Y/m/d');
        array_push($fees, $data);
        return $fees;
    }
    // copiando de los competidores a competition_prices
    public function fillDataPrices($company, $terminal, $price)
    {
        $data = [
            'company_id' => $company,
            'terminal_id' => $terminal,
            'regular' => $price->precio_regular != null ? $price->precio_regular : 0,
            'premium' => $price->precio_premium != null ? $price->precio_premium : 0,
            'diesel' => $price->precio_disel != null ? $price->precio_disel : 0,
            'created_at' => $price->created_at,
            'updated_at' => $price->updated_at
        ];
        return $data;
    }
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
