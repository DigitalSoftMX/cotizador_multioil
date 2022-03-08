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
        $names = ['operaciones multioil', 'operaciones policon', 'operaciones dihico'];

        $sheets = [];

        for ($i = 0; $i < count($kindOfAuth); $i++) {
            $orders = Order::where([['status_id', 2], ['type', $kindOfAuth[$i]]])->with(['company', 'payments'])->get();
            if ($orders->count() > 0)
                $sheets[] = new OrderExport(strtoupper($names[$i]), $orders);
        }

        return $sheets;
    }
}
