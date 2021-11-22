<?php

namespace App\Repositories;

use App\Company;

class Chartdata
{
    public function getDataOrder($column, $date = null)
    {
        $companies = [];
        foreach (Company::where('active', 1)->with('orders.payments')->get() as $company) {
            if (($orders = $company->orders->where('status_id', 2))->count() > 0) {
                $data['id'] = $company->id;
                $data['company'] = $company->alias;
                $data['total'] = 0;
                foreach ($orders as $order) {
                    $data['total'] += $date ?
                        $order->payments()->where('created_at', 'like' , "%{$date}%")->get()->sum($column) :
                        $order->payments->sum($column);
                }
                $data['total'] =$data['total'];
                array_push($companies, $data);
            }
        }
        return $companies;
    }
}
