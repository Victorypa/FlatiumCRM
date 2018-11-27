<?php

namespace App\Http\Controllers\Api\Orders\Acts\Rooms\Services;

use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Models\Services\Service;
use App\Http\Controllers\Controller;
use App\Models\Orders\Acts\ExtraOrderAct;
use App\Models\Orders\Acts\Rooms\ExtraRoom;

class ExtraRoomExtraServiceController extends Controller
{
    public function index(Order $order, ExtraOrderAct $extra_order_act, ExtraRoom $extra_room)
    {
        return response()->json([
            'room_services' => $extra_room->extra_services()->with(['actual_materials', 'unit', 'actual_materials.material_unit'])->get(),
            'extra_room' => $extra_room
        ]);
    }

    public function store(Order $order, ExtraOrderAct $extra_order_act, ExtraRoom $extra_room, Request $request)
    {
        $quantities = $request->service_quantities;

        $prices = $request->service_prices;

        $extra_room->extra_services()->sync($request->room_service_ids);

        foreach ($request->service_quantities as $service_id => $quantity) {
            $extra_room->extra_services()->updateExistingPivot($service_id, [
                'quantity' => $quantity = $quantities[$service_id],
                'price' => $quantity * $prices[$service_id]
            ]);
        }

        $this->calculateExtraRoomPrice($extra_room);

        $updated_extra_order_act = $this->calculateExtraOrderActPrice($extra_room);

        return response()->json([
            'extra_room' => $extra_room,
            'extra_order_act' => $updated_extra_order_act
        ]);
    }

    protected function calculateExtraOrderActPrice(ExtraRoom $extra_room)
    {
        $total_price = 0;

        $extra_rooms = $extra_room->ExtraOrderAct->extra_rooms;

        foreach ($extra_rooms as $new_room) {
            $total_price += (int) $new_room->price;
        }

        $extra_room->ExtraOrderAct->update([
            'price' => $total_price
        ]);

        return $extra_room->ExtraOrderAct->first();
    }

    protected function calculateExtraRoomPrice(ExtraRoom $extra_room)
    {
        $total_room_price = 0;

        if ($extra_room->room->order->discount !== null) {
            foreach ($extra_room->extra_services()->get() as $service) {
                if ($service->can_be_discounted) {
                    $total_room_price += $service->pivot->price * (float) (1 - (float) $extra_room->room->order->discount / 100);
                }
            }

            $extra_room->update([
                'price' => $total_room_price
            ]);

            $total_room_price = 0;

            return $extra_room;
        }

        if ($extra_room->room->order->markup !== null) {
            foreach ($extra_room->extra_services()->get() as $service) {
                $total_room_price += $service->pivot->price * (float) (1 + (float) $extra_room->room->order->markup / 100);
            }

            $extra_room->update([
                'price' => $total_room_price
            ]);

            $total_room_price = 0;

            return $extra_room;
        }

        if (!$extra_room->room->order->markup && !$extra_room->room->order->discount) {
            foreach ($extra_room->extra_services()->get() as $service) {
                $total_room_price += $service->pivot->price;
            }

            $extra_room->update([
                'price' => $total_room_price
            ]);

            $total_room_price = 0;

            return $extra_room;
        }

    }
}
