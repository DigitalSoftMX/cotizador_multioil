<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;

use App\Pedido;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class PedidosExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.semanalorders', ['pedidos' => Pedido::where('status_id', 2)->get()]);
    }
}
