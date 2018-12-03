<?php

namespace App\Models\Exports;

use App\Models\Orders\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

class OrdersExportWithoutMaterials implements FromView, ShouldAutoSize, WithEvents
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->styleCells(
                    'A1:A1',
                    [
                        'font' => array(
                            'name'      =>  'Calibri',
                            'size'      =>  15,
                            'bold'      =>  true,
                        )
                    ]
                );
            },
        ];
    }
}
