<table class="floor">
    <tr>
        <th class="table-subtitle">Наименование
        </th>
        <td class="table-subtitle">Кол-во</td>
        <td class="table-subtitle">Цена</td>
        <td class="table-subtitle">Стоимость</td>
    </tr>

    <tr class="borders">
        <th class="table-caption">{{ \App\Models\Services\ServiceType::where('id', $service_type_id)->first()->name }} </th>
        <td class="table-caption"></td>
        <td class="table-caption"></td>
        <td class="table-caption"></td>
    </tr>

    @foreach ($room_services as $room_service)
        <tr>
            <th>{{ \App\Models\Services\Service::where('id', $room_service->service_id)->first()->name }}</th>
            <td>{{ number_format((float) $room_service->quantity, 2, '.', '') }} {{ $room_service->unit->name }}</td>
            @if ($order->discount)
                @if (\App\Models\Services\Service::where('id', $room_service->service_id)->first()->can_be_discounted)
                    <td>{{ \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price * (1 - $order->discount/100) }} Р/{{ $room_service->unit->name }}</td>
                    <td>{{ number_format($room_service->quantity * \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price * (1 - $order->discount/100), 2, ',', ' ') }} Р</td>
                @else
                    <td>{{ \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price }} Р/{{ $room_service->unit->name }}</td>
                    <td>{{ number_format($room_service->quantity * \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price, 2, ',', ' ') }} Р</td>
                @endif
            @endif
            @if ($order->markup)
                <td>{{ \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price * (1 + $order->markup/100) }} Р/{{ $room_service->unit->name }}</td>
                <td>{{ number_format($room_service->quantity * \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price * (1 + $order->markup/100), 2, ',', ' ') }} Р</td>
            @endif
            @if ($order->discount === null && $order->markup === null)
                <td>{{ \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price }} Р/{{ $room_service->unit->name }}</td>
                <td>{{ number_format($room_service->quantity * \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price, 2, ',', ' ') }} Р</td>
            @endif
        </tr>
    @endforeach

</table>
