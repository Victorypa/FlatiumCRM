<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Flatium</title>

    @include('export.partials._styles')
</head>

<body>
    @include('export.partials._header')

    <section class="print ">
        <div class="container header-name">
            <div class="inline-block px-20">
                <h2 class="main-caption">
                    Акт дополнительных работ
                </h2>
                <div class="info-wrapper">
                    <div class="inline-block">
                        <div class="main-info">Итого по акту</div>
                        <div class="main-info">S объекта: </div>
                        <div class="main-info">Адрес: </div>
                        <div class="main-info">Заказчик:</div>
                        <div class="main-info">Менеджер: </div>
                    </div>
                    <div class="main-info-subtitles inline-block">
                        <div><b>{{ number_format((float) $filteredExtraOrder->price, 0, '', ' ') }} Р</b> @if ($filteredExtraOrder->order->discount) (с учётом скидки -{{ $filteredExtraOrder->order->discount }}%) @endif </div>
                        <div>{{ $total_area }} м² </div>
                        <div>{{ $filteredExtraOrder->order->address }}</div>
                        @if ($filteredExtraOrder->order->client_name)
                            <div>{{ $filteredExtraOrder->order->client_name }}</div>
                        @else
                            <div>&nbsp;</div>
                        @endif

                        @if ($filteredExtraOrder->order->manager)
                            <div>{{ $filteredExtraOrder->order->manager->name }} {{ $filteredExtraOrder->order->manager->phone }}</div>
                        @else
                            <div>&nbsp;</div>
                        @endif

                    </div>
                </div>
            </div>

            @if ($filteredExtraOrder->extra_rooms->count())
                @foreach ($filteredExtraOrder->extra_rooms->sortBy(['created_at']) as $index => $extra_room)
                    <div class="first-room">
                    <div class="first-room-top px-20">
                        <div class="main-subtitle pt-40 pb-20 inline-block">
                            @if ($extra_room->room->description)
                                {{ $extra_room->room->description }}
                            @else
                                {{ $extra_room->room->roomType->type }}
                            @endif

                        </div>
                        @if ($extra_room->room->room_type_id === 1)
                            @include('export.partials._room_details', ['room' => $extra_room->room])
                        @endif

                    </div>

                    @foreach ($extra_room->extra_room_services()->get()->groupBy(function($extra_room_service) { return $extra_room_service->service_type_id; }) as $service_type_id => $extra_room_services)
                        <table class="floor">
                            <tr>
                                <th class="table-subtitle">Наименование
                                </th>
                                <td class="table-subtitle">Кол-во</td>
                                <td class="table-subtitle">Цена</td>
                                <td class="table-subtitle">Стоимость</td>
                            </tr>
                            <tr class="borders">
                                <th class="table-caption">{{ \App\Models\Services\ServiceType::where('id', $service_type_id)->first()->name }}</th>
                                <td class="table-caption"></td>
                                <td class="table-caption"></td>
                                <td class="table-caption"></td>
                            </tr>

                            @foreach ($extra_room_services as $extra_room_service)
                                <tr>
                                    <th>{{ $extra_room_service->service->name }}</th>
                                    <td>{{ number_format((float) $extra_room_service->quantity, 2, '.', '') }} м<sup>2</sup></td>

                                    @if ($filteredExtraOrder->order->discount)
                                        @if ($extra_room_service->service->can_be_discounted)
                                            <td>{{ $extra_room_service->service->price * (1 - $filteredExtraOrder->order->discount/100) }} Р/м<sup>2</sup></td>
                                            <td>{{ number_format($extra_room_service->quantity * $extra_room_service->service->price * (1 - $filteredExtraOrder->order->discount/100), 2, ',', ' ') }} Р</td>
                                        @else
                                            <td>{{ $extra_room_service->service->price }} Р/м<sup>2</sup></td>
                                            <td>{{ number_format($extra_room_service->quantity * $extra_room_service->service->price, 2, ',', ' ') }} Р</td>
                                        @endif
                                    @endif

                                    @if ($filteredExtraOrder->order->markup)
                                        <td>{{ $extra_room_service->service->price * (1 + $filteredExtraOrder->order->markup/100) }} Р/м<sup>2</sup></td>
                                        <td>{{ number_format($extra_room_service->quantity * $extra_room_service->service->price * (1 + $filteredExtraOrder->order->markup/100), 2, ',', ' ') }} Р</td>
                                    @endif

                                    @if ($filteredExtraOrder->order->discount === null && $filteredExtraOrder->order->markup === null )
                                        <td>{{ $extra_room_service->service->price }} Р/м<sup>2</sup></td>
                                        <td>{{ number_format($extra_room_service->quantity * $extra_room_service->service->price, 2, ',', ' ') }} Р</td>
                                    @endif
                                </tr>
                            @endforeach

                        </table>
                    @endforeach

                </div>
                @endforeach
            @endif




            <div class="value-materials-wrapper">

                <table>

                    <tr class="borders">
                        <th class="table-caption full-summ-wrapper">
                        </th>

                        @if ($filteredExtraOrder->order->discount)
                            <td class="table-caption full-summ full-summ-wrapper py-25">Итого:
                                <br>
                                <span>Скидка {{ $filteredExtraOrder->order->discount }}%</span>
                            </td>
                        @else
                            <td class="table-caption full-summ full-summ-wrapper py-25">&nbsp;
                                <br>
                                <span>&nbsp;</span>
                            </td>
                        @endif

                        @if ($filteredExtraOrder->order->discount)
                            <td class="table-caption full-summ full-summ-wrapper" colspan="2">
                                {{ number_format((int) $filteredExtraOrder->order->original_price, 0, '', ' ') }} Р
                                <br>
                                <span>{{ number_format((int) $filteredExtraOrder->order->price, 0, '', ' ') }} Р</span>
                            </td>
                        @else
                            <td class="table-caption full-summ full-summ-wrapper" colspan="2">
                                {{ number_format((int) $filteredExtraOrder->order->price, 0, '', ' ') }} Р
                                <br>
                                <span>&nbsp;</span>
                            </td>
                        @endif
                    </tr>
                </table>

            </div>

            @include('export.partials._comment', ['order' => $filteredExtraOrder->order])
    </section>

</body>
