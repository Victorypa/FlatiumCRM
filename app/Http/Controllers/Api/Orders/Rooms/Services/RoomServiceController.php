<?php

namespace App\Http\Controllers\Api\Orders\Rooms\Services;

use Illuminate\Http\Request;
use App\Models\Orders\Order;
use App\Models\Orders\Rooms\Room;
use App\Models\Services\Service;
use App\Http\Controllers\Controller;

class RoomServiceController extends Controller
{
    public function index(Order $order, Room $room)
    {
        return response()->json([
            'room_services' => $room->services()->with(['actual_materials', 'materials', 'unit', 'materials.material_unit'])->get(),
            'room' => $room
        ]);
    }

    public function store(Order $order, Room $room, Request $request)
    {
        $quantities = $request->service_quantities;

        $prices = $request->service_prices;

        $room->services()->sync($request->room_service_ids);

        foreach ($request->service_quantities as $service_id => $quantity) {
            $currentService = Service::where('id', (int)$service_id)->first();

            if ($order->discount && $currentService->can_be_discounted) {
                $room->services()->updateExistingPivot($service_id, [
                    'quantity' => $quantity = $quantities[$service_id],
                    'price' => $quantity * $currentService->price * (1 - (float)$order->discount/100)
                ]);
            }

            if ($order->markup) {
                $room->services()->updateExistingPivot($service_id, [
                    'quantity' => $quantity = $quantities[$service_id],
                    'price' => $quantity * $currentService->price * (1 + (float)$order->markup/100)
                ]);
            }

            if ($order->discount === null && $order->markup === null) {
                $room->services()->updateExistingPivot($service_id, [
                    'quantity' => $quantity = $quantities[$service_id],
                    'price' => $quantity * $currentService->price
                ]);
            }
        }

        $updatedRoom = $room->calculateRoomPrice($room);

        $updatedOrder = $room->calculateOrderPrice($room);

        return response()->json([
            'room' => $updatedRoom,
            'order' => $updatedOrder
        ]);
    }
}
