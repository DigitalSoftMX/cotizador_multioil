<?php

namespace App\Exports;

use App\Exports\Sheets\OrderExport;
use App\Order;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class OrderExcelExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $kindOfAuth = ['prepago', 'credito', 'itzel'];
        $sheets = [];
        foreach ($kindOfAuth as $koa) {
            $orders = Order::where([['status_id', 2], ['type', $koa]])->with(['company', 'payments'])->get();
            if ($orders->count() > 0)
                $sheets[] = new OrderExport(strtoupper($koa), $orders);
        }
        return $sheets;
    }
}
