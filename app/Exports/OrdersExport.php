<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use App\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class OrdersExport implements FromView
{
    private $state, $user;
    public function __construct($state, $user = null)
    {
        $this->state = $state;
        $this->user = $user;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        switch ($this->state) {
            case 1:
                return view('exports.dailyorders', ['orders' => Order::where('status_id', 2)->get()]);
            case 2:
                return view('exports.sales', ['orders' => Order::where('status_id', 2)->get()]);
            case 3:
                return view('exports.commissionsales', ['orders' => $this->user->orders->where('status_id', 2)]);
        }
    }
}
