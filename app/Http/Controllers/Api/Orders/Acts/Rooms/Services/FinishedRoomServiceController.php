<?php

namespace App\Http\Controllers\Api\Orders\Acts\Rooms\Services;

use Illuminate\Http\Request;
use App\Models\Orders\Order;
use App\Models\Services\Service;
use App\Http\Controllers\Controller;
use App\Models\Orders\Acts\FinishedOrderAct;
use App\Models\Orders\Acts\Rooms\FinishedRoom;

class FinishedRoomServiceController extends Controller
{
    public function index(Order $order, FinishedOrderAct $finished_order_act, FinishedRoom $finished_room, Request $request)
    {
        return response()->json([
            'selected_services' => $finished_room->finished_services()->get(),
            'finished_room' => $finished_room
        ]);
    }

    public function store(Order $order, FinishedOrderAct $finished_order_act, Request $request)
    {
        $finished_room = FinishedRoom::where('id', $request->finished_room_id)->first();

        $finished_room->finished_services()->sync($request->selected_service_ids);

        $quantities = $request->selected_service_quantities;


        foreach ($request->selected_service_quantities as $selected_service_id => $quantity) {

            $currentService = Service::where('id', $selected_service_id)->first();

            if ($order->discount && $currentService->can_be_discounted) {
                $finished_room->finished_services()->updateExistingPivot($selected_service_id, [
                    'quantity' => $quantity = $quantities[$selected_service_id],
                    'price' => $quantity * $currentService->price * (1 - (float)$order->discount/100),
                    'service_type_id' => $currentService->service_type_id,
                    'service_unit_id' => $currentService->unit_id
                ]);
            }
            if ($order->markup) {
                $finished_room->finished_services()->updateExistingPivot($selected_service_id, [
                    'quantity' => $quantity = $quantities[$selected_service_id],
                    'price' => $quantity * $currentService->price * (1 + (float)$order->markup/100),
                    'service_type_id' => $currentService->service_type_id,
                    'service_unit_id' => $currentService->unit_id
                ]);
            }

            if ($order->discount === null && $order->markup === null) {
                $finished_room->finished_services()->updateExistingPivot($selected_service_id, [
                    'quantity' => $quantity = $quantities[$selected_service_id],
                    'price' => $quantity * $currentService->price,
                    'service_type_id' => $currentService->service_type_id,
                    'service_unit_id' => $currentService->unit_id
                ]);
            }
        }

        $price = 0;

        $this->updateFinishedRoomPrice($finished_room);

        return response()->json($price);

    }

    protected function updateFinishedRoomPrice(FinishedRoom $finished_room)
    {
        $price = 0;

        foreach ($finished_room->finished_services()->get() as $finished_service) {
            $price += (float) $finished_service->pivot->price;
        }

        $finished_room->update([
            'price' => $price
        ]);

        $total_price = $this->updateFinishedOrderActPrice($finished_room);

        return $total_price;
    }

    protected function updateFinishedOrderActPrice(FinishedRoom $finished_room)
    {
        $price = 0;

        foreach ($finished_room->FinishedOrderAct->finished_rooms as $finished_room) {
            $price += $finished_room->price;
        }
        $finished_room->FinishedOrderAct->update([
            'price' => $price
        ]);

        return $price;
    }
}
