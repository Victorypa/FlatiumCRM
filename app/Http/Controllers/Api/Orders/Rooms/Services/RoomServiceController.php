<?php

namespace App\Http\Controllers\Api\Orders\Rooms\Services;

use Illuminate\Http\Request;
use App\Models\Orders\Order;
use App\Models\Orders\Rooms\Room;
use App\Modes\Orders\Rooms\Services\RoomService;
use App\Models\Services\Service;
use App\Http\Controllers\Controller;

class RoomServiceController extends Controller
{
    // public function index(Order $order, Room $room)
    // {
    //     return response()->json([
    //         'room_services' => $room->room_services()->get(),
    //         'room' => $room
    //     ]);
    // }

    public function store(Order $order, Room $room, Request $request)
    {
        $quantities = $request->service_quantities;

        $prices = $request->service_prices;

        $existed_room_service_ids = [];

        $existed_room_service_ids = $room->getExistedRoomServicesIds($room);

        // Refactoring TODO
        if (count($diffIds = array_diff($request->room_service_ids, $existed_room_service_ids)) != 0) {
            // we have new record
            foreach ($diffIds as $key => $service_id) {
                $room->room_services()->create([
                    'service_id' => $service_id
                ]);
            }

            foreach ($request->service_quantities as $service_id => $quantity) {
                $currentService = Service::where('id', $service_id)->first();

                if ($order->discount) {
                    if ($currentService->can_be_discounted) {
                        $room->room_services()->where('service_id', $service_id)->update([
                            'quantity' => $quantity,
                            'price' => $quantity * $currentService->price * (1 - (float)$order->discount/100)
                        ]);
                    } else {
                        $room->room_services()->where('service_id', $service_id)->update([
                            'quantity' => $quantity,
                            'price' => $quantity * $currentService->price
                        ]);
                    }
                }

                if ($order->markup) {
                    $room->room_services()->where('service_id', $service_id)->update([
                        'quantity' => $quantity,
                        'price' => $quantity * $currentService->price * (1 + (float)$order->markup/100)
                    ]);
                }

                if ($order->discount === null && $order->markup === null) {
                    $room->room_services()->where('service_id', $service_id)->update([
                        'quantity' => $quantity,
                        'price' => $quantity * $currentService->price
                    ]);
                }
            }
        } else {
            // we dont have new record
            foreach ($request->service_quantities as $service_id => $quantity) {
                $currentService = Service::where('id', $service_id)->first();

                if ($order->discount) {
                    if ($currentService->can_be_discounted) {
                        $room->room_services()->where('service_id', $service_id)->update([
                            'quantity' => $quantity,
                            'price' => $quantity * $currentService->price * (1 - (float)$order->discount/100)
                        ]);
                    } else {
                        $room->room_services()->where('service_id', $service_id)->update([
                            'quantity' => $quantity,
                            'price' => $quantity * $currentService->price
                        ]);
                    }
                }

                if ($order->markup) {
                    $room->room_services()->where('service_id', $service_id)->update([
                        'quantity' => $quantity,
                        'price' => $quantity * $currentService->price * (1 + (float)$order->markup/100)
                    ]);
                }

                if ($order->discount === null && $order->markup === null) {
                    $room->room_services()->where('service_id', $service_id)->update([
                        'quantity' => $quantity,
                        'price' => $quantity * $currentService->price
                    ]);
                }
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
