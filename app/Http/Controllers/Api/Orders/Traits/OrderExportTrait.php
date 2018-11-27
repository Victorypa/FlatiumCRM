<?php

namespace App\Http\Controllers\Api\Orders\Traits;

use PDF;
use Storage;
use App\Models\Orders\Order;

trait OrderExportTrait
{
    protected function export($filteredOrder, $path)
    {
        $total_area = 0;
        foreach ($filteredOrder->rooms as $room) {
            $total_area += (float)$room->area;
        }

        $name = str_random(12);

        $pdf = PDF::setOptions([['defaultFont' => 'DejaVu Sans, Arial']])
                  ->loadView($path, array('order' => $filteredOrder, 'total_area' => $total_area))
                  ->setPaper('a4', 'portrait');


        $pdf = $pdf->save($path = storage_path("app/public/$name.pdf"));

        if (!$pdf) {
            return response()->json(['message' => 'some error']);
        }

        $response = Storage::disk('local')->put(
            $this->buildFilePath($name),
            file_get_contents($path)
        );

        if ($response) {
            return response()->json([
                "url" => url('/'),
                "data" => "$name.pdf"
            ]);
        }
    }

    protected function exportWithMaterials($filteredOrder, $path)
    {
        $total_area = 0;
        foreach ($filteredOrder->rooms as $room) {
            $total_area += (float) $room->area;
        }

        $name = str_random(12);

        $material_names = $this->getMaterials($filteredOrder, 'name');
        $material_rates = $this->getMaterials($filteredOrder, 'rate');
        $material_quantites = $this->getMaterials($filteredOrder, 'quantity');
        $material_prices = $this->getMaterials($filteredOrder, 'price');

        $material_total_price = 0;

        foreach ($material_rates as $id => $value) {
            $material_total_price += ceil($material_rates[$id] / $material_quantites[$id]) * $material_prices[$id];
        }

        $pdf = PDF::setOptions([['defaultFont' => 'DejaVu Sans']])
                  ->loadView($path, array(
                      'order' => $filteredOrder,
                      'total_area' => $total_area,
                      'material_names' => $material_names,
                      'material_rates' => $material_rates,
                      'material_quantites' => $material_quantites,
                      'material_prices' => $material_prices,
                      'material_total_price' => $material_total_price
                  ))
                  ->setPaper('a4', 'portrait');


        $pdf = $pdf->save($path = storage_path("app/public/$name.pdf"));

        if (!$pdf) {
            return response()->json(['message' => 'some error']);
        }

        $response = Storage::disk('local')->put(
            $this->buildFilePath($name),
            file_get_contents($path)
        );

        if ($response) {
            return response()->json([
                "url" => url('/'),
                "data" => "$name.pdf"
            ]);
        }
    }



    protected function getMaterials(Order $filteredOrder, $type)
    {
        $material_ids = [];
        $material_names = [];
        $material_quantites = [];
        $material_rates = [];
        $material_prices = [];

        foreach ($filteredOrder->rooms as $room) {
            foreach ($room->services()->get() as $service) {
                foreach ($service->actual_materials as $material) {
                    array_push($material_ids, $material->id);
                    $material_names[$material->id] = $material->name;
                    $material_prices[$material->id] = (float) $material->price;

                    if ($material->quantity != null) {
                        $material_quantites[$material->id] = (float) $material->quantity;
                    } else {
                        $material_quantites[$material->id] = 0;
                    }

                    if ($material->pivot->rate != null) {
                        if (!array_key_exists($material->id, $material_rates)) {
                            $material_rates[$material->id] = (float) $material->pivot->rate;
                        }  else {
                            $material_rates[$material->id] += (float) $material->pivot->rate;
                        }

                    } else {
                        $material_rates[$material->id] = 0;
                    }
                }
            }

        }

        switch ($type) {
            case 'name':
                return $material_names;
                break;
            case 'rate':
                return $material_rates;
                break;
            case 'quantity':
                return $material_quantites;
                break;

            case 'price':
                return $material_prices;
                break;
            default:
                return;
                break;
        }
    }

    protected function buildFilePath($name)
    {
       return 'pdfs/' . $name . '.pdf';
    }
}
