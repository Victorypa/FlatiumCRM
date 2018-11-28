<?php

namespace App\Http\Controllers\Api\Orders\Acts\Rooms\Services;

use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Models\Services\Service;
use App\Http\Controllers\Controller;
use App\Models\Orders\Acts\ExtraOrderAct;
use App\Models\Orders\Acts\Rooms\ExtraRoom;

class ExtraRoomServiceController extends Controller
{
    public function store(Order $order, ExtraOrderAct $extra_order_act, ExtraRoom $extra_room, Request $request)
    {
        $diffIds_add = [];
        $diffIds_delete = [];

        $quantities = $request->service_quantities;

        $prices = $request->service_prices;

        $existed_extra_room_service_ids = [];

        $existed_extra_room_service_ids = $extra_room->getExistedExtraRoomServicesIds($extra_room);
        $diffIds_add = array_diff($request->room_service_ids, $existed_extra_room_service_ids);
        $diffIds_delete = array_diff($existed_extra_room_service_ids, $request->room_service_ids);

        if (count($diffIds_add) != 0) {
            foreach ($diffIds_add as $key => $service_id) {
                $extra_room->extra_room_services()->create([
                    'service_id' => $service_id
                ]);
            }

            foreach ($request->service_quantities as $service_id => $quantity) {
                $currentService = Service::where('id', $service_id)->first();

                if ($order->discount) {
                    if ($currentService->can_be_discounted) {
                        $extra_room->extra_room_services()->where('service_id', $service_id)->update([
                            'service_type_id' => $currentService->service_type_id,
                            'service_unit_id' => $currentService->unit_id,
                            'quantity' => $quantity,
                            'price' => $quantity * $currentService->price * (1 - (float)$order->discount/100)
                        ]);
                    } else {
                        $extra_room->extra_room_services()->where('service_id', $service_id)->update([
                            'service_type_id' => $currentService->service_type_id,
                            'service_unit_id' => $currentService->unit_id,
                            'quantity' => $quantity,
                            'price' => $quantity * $currentService->price
                        ]);
                    }
                }

                if ($order->markup) {
                    $extra_room->extra_room_services()->where('service_id', $service_id)->update([
                        'service_type_id' => $currentService->service_type_id,
                        'service_unit_id' => $currentService->unit_id,
                        'quantity' => $quantity,
                        'price' => $quantity * $currentService->price * (1 + (float)$order->markup/100)
                    ]);
                }

                if ($order->discount === null && $order->markup === null) {
                    $extra_room->extra_room_services()->where('service_id', $service_id)->update([
                        'service_type_id' => $currentService->service_type_id,
                        'service_unit_id' => $currentService->unit_id,
                        'quantity' => $quantity,
                        'price' => $quantity * $currentService->price
                    ]);
                }
            }
        }

        if (count($diffIds_delete) != 0 ) {
            foreach ($diffIds_delete as $key => $service_id) {
                $extra_room->extra_room_services()->where('service_id', $service_id)->delete();
            }
        }
        // TODO
        if (count($diffIds_delete) === 0 && count($diffIds_add) === 0) {

            foreach ($request->service_quantities as $service_id => $quantity) {
                $currentService = Service::where('id', $service_id)->first();

                if ($order->discount) {
                    if ($currentService->can_be_discounted) {
                        $room->room_services()->where('service_id', $service_id)->update([
                            'service_type_id' => $currentService->service_type_id,
                            'service_unit_id' => $currentService->unit_id,
                            'quantity' => $quantity,
                            'price' => $quantity * $currentService->price * (1 - (float)$order->discount/100)
                        ]);
                    } else {
                        $room->room_services()->where('service_id', $service_id)->update([
                            'service_type_id' => $currentService->service_type_id,
                            'service_unit_id' => $currentService->unit_id,
                            'quantity' => $quantity,
                            'price' => $quantity * $currentService->price
                        ]);
                    }
                }

                if ($order->markup) {
                    $room->room_services()->where('service_id', $service_id)->update([
                        'service_type_id' => $currentService->service_type_id,
                        'service_unit_id' => $currentService->unit_id,
                        'quantity' => $quantity,
                        'price' => $quantity * $currentService->price * (1 + (float)$order->markup/100)
                    ]);
                }

                if ($order->discount === null && $order->markup === null) {
                    $room->room_services()->where('service_id', $service_id)->update([
                        'service_type_id' => $currentService->service_type_id,
                        'service_unit_id' => $currentService->unit_id,
                        'quantity' => $quantity,
                        'price' => $quantity * $currentService->price
                    ]);
                }
            }
        }

        // return response()->json([
        //     'extra_room' => $extra_room,
        //     'extra_order_act' => $updated_extra_order_act
        // ]);
    }
}
