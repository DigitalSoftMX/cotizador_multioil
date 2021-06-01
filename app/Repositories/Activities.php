<?php

namespace App\Repositories;

use App\Company;
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
                    if ($fee != null) {
                        $data['terminal'] = $fee->terminals->business_name;
                        $data['company'] = $fee->companies->name;
                        $data['commission'] = '$ ' . $fee->commission;
                        $data['regular_fit'] = '$ ' . $fee->regular_fit;
                        $data['premium_fit'] = '$ ' . $fee->premium_fit;
                        $data['diesel_fit'] = '$ ' . $fee->diesel_fit;
                        $data['created_at'] = $fee->created_at->format('Y/m/d');
                        array_push($fees, $data);
                    }
                }
            } else {
                $fee = $terminal->fits->where('company_id', $company_id)->last();
                if ($fee != null) {
                    $data['terminal'] = $fee->terminals->business_name;
                    $data['company'] = $fee->companies->name;
                    $data['commission'] = '$ ' . $fee->commission;
                    $data['regular_fit'] = '$ ' . $fee->regular_fit;
                    $data['premium_fit'] = '$ ' . $fee->premium_fit;
                    $data['diesel_fit'] = '$ ' . $fee->diesel_fit;
                    $data['created_at'] = $fee->created_at->format('Y/m/d');
                    array_push($fees, $data);
                }
            }
        }
        return $fees;
    }
}
