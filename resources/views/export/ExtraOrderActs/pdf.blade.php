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

            @if (count($filteredExtraOrder->extra_rooms))
                @foreach ($filteredExtraOrder->extra_rooms->sortBy(['room.room_type_id']) as $index => $extra_room)
                    @if (count($extra_room->extra_room_services))
                        <div class="first-room" style="margin-top: 30px;">
                          <div class="first-room-top px-20 border-black">
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

                            <div class="first-room-top background-solid"></div>

                            @if ($extra_room->extra_room_services->count())
                              @foreach ($extra_room->extra_room_services()->orderBy('service_type_id', 'asc')->get()->groupBy(function($extra_room_service) { return $extra_room_service->service_type_id; }) as $service_type_id => $extra_room_services)
                                  @include('export.partials._room_services', [
                                    'service_type_id' => $service_type_id,
                                    'room_services' => $extra_room_services,
                                    'order' => $filteredExtraOrder->order
                                  ])
                              @endforeach
                            @endif

                            <table>
                                <tr class="borders">
                                    <th class="table-caption"></th>
                                    <td class="table-caption"></td>
                                    <td class="table-caption"></td>
                                    <td class="table-caption">
                                        <strong class="font-size-fix"><b>{{ number_format($extra_room->price, 0, ',', ' ') }} Р</b></strong>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    @endif
                @endforeach
            @endif




            <div class="value-materials-wrapper">
                @if ($filteredExtraOrder->order->discount)
                    <table class="border-free">
                        <tr class="border-free">
                            <th class="table-caption border-free background-free"></th>

                            <td class="py-25 table-caption border-free ml-20"><strong><b>ИТОГО:</b></strong>
                                <br>
                                <span class="font-size-fix">Скидка {{ $filteredExtraOrder->order->discount }}%</span>
                            </td>
                            <td class="table-caption border-free ml-15" colspan="2">
                                <strong class="font-size-fix"><b>{{ number_format((int) $filteredExtraOrder->order->original_price, 0, '', ' ') }} Р</b></strong>
                                <strong class="font-size-fix"><b>{{ number_format((int) $filteredExtraOrder->order->price, 0, '', ' ') }} Р</b></strong>
                            </td>

                        </tr>
                    </table>
                @endif

                @if ($filteredExtraOrder->order->markup)
                    <table class="border-free">
                        <tr class="border-free">
                            <th class="table-caption border-free background-free"></th>

                            <td class="py-25 table-caption border-free ml-20"><strong><b>ИТОГО:</b></strong></td>

                            <td class="table-caption border-free ml-15 font-size-fix" colspan="2">{{ number_format((int) $filteredExtraOrder->order->price, 0, '', ' ') }} Р
                            </td>

                        </tr>
                    </table>
                @endif

                @if ($filteredExtraOrder->order->discount === null && $filteredExtraOrder->order->markup === null)
                  <div class="container">
                    <table class="border-free">
                        <tr class="border-free">
                            <th class="table-caption border-free background-free"></th>
                            <td class="py-25 table-caption border-free ml-20"><strong><b>ИТОГО:</b></strong></td>
                            <td class="table-caption border-free ml-15 font-size-fix" colspan="2"><strong><b>{{ number_format($filteredExtraOrder->order->price, 0, '', ' ') }} Р</b></strong></td>
                        </tr>
                    </table>
                  </div>
                @endif
            </div>

            {{-- @include('export.partials._comment', ['order' => $filteredExtraOrder->order]) --}}
    </section>

</body>
