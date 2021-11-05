<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithTitle;

class OrderExport implements FromView, WithTitle
{
    private $title, $order;
    public function __construct($title, $order)
    {
        $this->title = $title;
        $this->order = $order;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.sales', ['orders' => $this->order]);
    }
    // Titulo de cada página
    public function title(): string
    {
        return $this->title;
    }
}
