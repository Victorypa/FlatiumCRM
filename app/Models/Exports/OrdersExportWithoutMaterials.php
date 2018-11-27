<?php

namespace App\Models\Exports;

use App\Models\Orders\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrdersExportWithoutMaterials implements FromView
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function view(): View
    {
        $total_area = 0;

        foreach ($this->order->rooms as $room) {
            $total_area = 0;
            $total_area += $room->area;
        }

        return view('export.excel.excel', [
            'order' => $this->order,
            'total_area' => $total_area
        ]);
    }
}
