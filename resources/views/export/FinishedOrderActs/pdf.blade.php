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
                    Акт выполненных работ
                </h2>
                <div class="info-wrapper">
                    <div class="inline-block">
                        <div class="main-info">Отчётный период:</div>
                        <div class="main-info">Итого по акту</div>
                        <div class="main-info">S объекта: </div>
                        <div class="main-info">Адрес: </div>

                        <div class="main-info">Телефон: </div>
                        <div class="main-info">Почта: </div>

                        <div class="main-info">Заказчик:</div>
                        <div class="main-info">Менеджер: </div>
                    </div>
                    <div class="main-info-subtitles inline-block">
                        @if ($filteredFinishedOrderAct->begin_at && $filteredFinishedOrderAct->finish_at)
                            <div>{{ $filteredFinishedOrderAct->begin_at->format('d.m.Y') }} - {{ $filteredFinishedOrderAct->finish_at->format('d.m.Y') }}</div>
                        @else
                            <div>
                                &nbsp;
                            </div>
                        @endif


                        <div><b>{{ number_format((float) $selected_price, 0, '', ' ') }} Р</b> @if ($filteredFinishedOrderAct->order->discount) с учётом скидки -{{ $filteredFinishedOrderAct->order->discount }}%  @endif </div>
                        <div>{{ $total_area }} м² </div>
                        <div>{{ $filteredFinishedOrderAct->order->address }}</div>

                        @if ($filteredFinishedOrderAct->order->user->phone)
                            <div>{{ $filteredFinishedOrderAct->order->user->phone }}</div>
                        @else
                            <div>&nbsp;</div>
                        @endif

                        @if ($filteredFinishedOrderAct->order->user->phone)
                            <div>{{ $filteredFinishedOrderAct->order->user->phone }}</div>
                        @else
                            <div>&nbsp;</div>
                        @endif

                        @if ($filteredFinishedOrderAct->order->client_name)
                            <div>{{ $filteredFinishedOrderAct->order->client_name }}</div>
                        @else
                            <div>&nbsp;</div>
                        @endif

                        @if ($filteredFinishedOrderAct->order->manager)
                            <div>{{ $filteredFinishedOrderAct->order->manager->name }} {{ $filteredFinishedOrderAct->order->manager->phone }}</div>
                        @else
                            <div>&nbsp;</div>
                        @endif

                    </div>
                </div>
            </div>

            @if (count($filteredFinishedOrderAct->finished_rooms))
                @foreach ($filteredFinishedOrderAct->finished_rooms as $finished_room)
                    <div class="first-room">
                        <div class="first-room-top px-20">
                            <div class="main-subtitle pt-40 pb-20 inline-block">
                                {{ $finished_room->room->description ? $finished_room->room->description : $finished_room->room->roomType->type }}
                            </div>

                            @if ($finished_room->room->room_type_id === 1)
                                @include('export.partials._room_details', ['room' => $finished_room])
                            @endif
                        </div>
                    </div>

                    @if (count($finished_room->finished_room_services))
                        @foreach ($finished_room->finished_room_services()->get()->groupBy(function($finished_room_service) { return $finished_room_service->service->service_type_id; }) as $service_type_id => $finished_room_services)
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


                                @foreach ($finished_room_services as $finished_room_service)
                                    <tr>
                                        <th>{{ $finished_room_service->service->name }}</th>
                                        <td>{{ number_format((float) $finished_room_service->quantity, 2, '.', '') }} Р/{{ $finished_room_service->service->unit->name }}</td>

                                        @if ($filteredFinishedOrderAct->order->discount)
                                            @if ($finished_room_service->service->can_be_discounted)
                                                <td>{{ $finished_room_service->service->price * (1 - $filteredFinishedOrderAct->order->discount/100) }} Р/{{ $finished_room_service->service->unit->name }}</td>
                                            @else
                                                <td>{{ $finished_room_service->service->price }} Р/м<sup>2</sup></td>
                                            @endif
                                        @endif

                                        @if ($filteredFinishedOrderAct->order->markup)
                                                <td>{{ $finished_room_service->service->price * (1 + $filteredFinishedOrderAct->order->markup/100) }} Р/{{ $finished_room_service->service->unit->name }}</td>
                                        @endif

                                        @if ($filteredFinishedOrderAct->order->markup === null && $filteredFinishedOrderAct->order->discount === null)
                                            <td>{{ $finished_room_service->service->price }} Р/{{ $finished_room_service->service->unit->name }}</td>
                                        @endif
                                        <td>{{ number_format($finished_room_service->price, 2, ',', ' ') }} Р</td>
                                    </tr>
                                @endforeach
                            </table>
                        @endforeach
                    @endif
                @endforeach
            @endif

            {{-- @include('export.partials._comment', ['order' => $filteredFinishedOrderAct->order]) --}}
    </section>

</body>
