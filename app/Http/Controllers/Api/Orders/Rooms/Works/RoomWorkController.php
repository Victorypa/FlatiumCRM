<?php

namespace App\Http\Controllers\Api\Orders\Rooms\Works;

use App\Models\Work\Work;
use App\Models\Orders\Order;
use App\Models\Orders\Rooms\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomWorkController extends Controller
{
    public function index(Order $order, Room $room)
    {
        $begin_ats = [];
        $finish_ats = [];
        $begin_ats_in_fact = [];
        $finish_ats_in_fact = [];

        $works = Work::orderBy('name', 'asc')->get();

        foreach ($works as $work) {
            $begin_ats[$work->id] = $room->works()->where('work_id', $work->id)->first()->pivot->begin_at;
            $finish_ats[$work->id] = $room->works()->where('work_id', $work->id)->first()->pivot->finish_at;
            $begin_ats_in_fact[$work->id] = $room->works()->where('work_id', $work->id)->first()->pivot->begin_at_in_fact;
            $finish_ats_in_fact[$work->id] = $room->works()->where('work_id', $work->id)->first()->pivot->finish_at_in_fact;
        }

        $filterdOrder = Order::where('id', $order->id)->with(['rooms', 'rooms.roomType'])->first();
        $filteredRoom = Room::where('id', $room->id)->with(['works'])->first();

        return response()->json([
            'order' => $filterdOrder,
            'room' => $filteredRoom,
            'works' => $works,
            'begin_ats' => $begin_ats,
            'finish_ats' => $finish_ats,
            'begin_ats_in_fact' => $begin_ats_in_fact,
            'finish_ats_in_fact' => $finish_ats_in_fact
        ]);
    }

    public function update(Order $order, Room $room, Request $request)
    {
        if ($request->begin_ats || $request->finish_ats) {
            foreach ($request->begin_ats as $key => $value) {
                $room->works()->updateExistingPivot($key, [
                    'begin_at' => $value
                ]);
            }

            foreach ($request->finish_ats as $key => $value) {
                $room->works()->updateExistingPivot($key, [
                    'finish_at' => $value
                ]);
            }
        }

        if ($request->begin_ats_in_fact || $request->finish_ats_in_fact) {
            foreach ($request->begin_ats_in_fact as $key => $value) {
                $room->works()->updateExistingPivot($key, [
                    'begin_at_in_fact' => $value
                ]);
            }

            foreach ($request->finish_ats_in_fact as $key => $value) {
                $room->works()->updateExistingPivot($key, [
                    'finish_at_in_fact' => $value
                ]);
            }
        }



    }
}
