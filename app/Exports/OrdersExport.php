<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use App\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class OrdersExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.dailyorders', ['orders' => Order::where('status_id', 2)->get()]);
    }
}
