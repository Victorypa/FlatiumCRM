<?php

namespace App\Http\Controllers\Api\Orders\Acts\Rooms\Services;

use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Models\Services\Service;
use App\Http\Controllers\Controller;
use App\Models\Orders\Acts\ExtraOrderAct;
use App\Models\Orders\Acts\Rooms\ExtraRoom;
use App\Models\Orders\Acts\Rooms\Services\ExtraRoomService;

class ExtraRoomServiceController extends Controller
{
    public function show(Order $order, ExtraOrderAct $extra_order_act, ExtraRoom $extra_room, Service $extra_service, Request $request)
    {
        return ExtraRoomService::where([
            ['extra_room_id', $extra_room->id],
            ['service_id', $extra_service->id]
        ])->first();
    }

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

        if (count($diffIds_delete) === 0 && count($diffIds_add) === 0) {

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

        foreach ($extra_room->extra_room_services()->get() as $service) {
            $total_room_price += $service->price ;
        }

            $extra_room->update([
                'price' => $total_room_price
            ]);

            $total_room_price = 0;

            return $extra_room;
    }
}
