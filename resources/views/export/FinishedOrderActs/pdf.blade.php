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
                            @if ($finished_room->room->description)
                                <div class="main-subtitle pt-40 pb-20 inline-block">
                                    {{ $finished_room->room->description }}
                                </div>
                            @else
                                <div class="main-subtitle pt-40 pb-20 inline-block">
                                    {{ $finished_room->room->roomType->type }}
                                </div>
                            @endif
                            @if ($finished_room->room->room_type_id === 1)
                                <div class="room-features inline-block">
                                    <div class="info-item">S: {{ $finished_room->room->area }} м<sup>2</sup></div>
                                    <div class="info-item">H: {{ $finished_room->room->height }} м</div>
                                    <div class="info-item">S стен: {{ $finished_room->room->wall_area }} м<sup>2</sup></div>
                                    <div class="info-item">P: {{ $finished_room->room->perimeter }} м.п.</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if (count($finished_room->finished_services))
                        @foreach ($finished_room->finished_services()->get()->groupBy(function($finished_service) { return $finished_service->service_type_id; }) as $service_type_id => $finished_services)
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


                                @foreach ($finished_services as $finished_service)
                                    <tr>
                                        <th>{{ $finished_service->name }}</th>
                                        <td>{{ number_format((float) $finished_service->pivot->quantity, 2, '.', '') }} м<sup>2</sup></td>

                                        @if ($filteredFinishedOrderAct->order->discount)
                                            @if ($finished_service->can_be_discounted)
                                                <td>{{ $finished_service->price * (1 - $filteredFinishedOrderAct->order->discount/100) }} Р/м<sup>2</sup></td>
                                                <td>{{ number_format($finished_service->price * (1 - $filteredFinishedOrderAct->order->discount/100) * $finished_service->pivot->quantity, 2, ',', ' ') }} Р</td>
                                                @else
                                                    <td>{{ $finished_service->price }} Р/м<sup>2</sup></td>
                                                    <td>{{ number_format($finished_service->pivot->quantity * $finished_service->price, 2, ',', ' ') }} Р</td>
                                            @endif
                                        @endif

                                        @if ($filteredFinishedOrderAct->order->markup)
                                                <td>{{ $finished_service->price * (1 + $filteredFinishedOrderAct->order->markup/100) }} Р/м<sup>2</sup></td>
                                                <td>{{ number_format($finished_service->price * (1 + $filteredFinishedOrderAct->order->markup/100) * $finished_service->pivot->quantity, 2, ',', ' ') }} Р</td>
                                        @endif

                                        @if ($filteredFinishedOrderAct->order->markup === null && $filteredFinishedOrderAct->order->discount === null)
                                            <td>{{ $finished_service->price }} Р/м<sup>2</sup></td>
                                            <td>{{ number_format($finished_service->pivot->quantity * $finished_service->price, 2, ',', ' ') }} Р</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                        @endforeach
                    @endif
                @endforeach
            @endif


            <div class="container comment">
                <div>
                    С другой стороны укрепление и развитие структуры обеспечивает широкому кругу (специалистов) участие
                    в формировании системы обучения кадров, соответствует насущным потребностям. Значимость этих
                    проблем настолько очевидна, что начало повседневной работы по формированию позиции играет важную
                    роль в формировании новых предложений. Не следует, однако забывать, что сложившаяся структура
                    организации играет важную роль в формировании систем массового участия. Таким образом начало
                    повседневной работы по формированию позиции обеспечивает широкому кругу (специалистов) участие в
                    формировании новых предложений.
                    <br>
                    @if ($filteredFinishedOrderAct->order->contract)
                        <span>Приложение к договору № {{ $filteredFinishedOrderAct->order->contract }}</span>
                    @else
                        <span>&nbsp;</span>
                    @endif
                </div>

            </div>

            <div class="container signature-item">
                <div class="signature inline-block">Заказчик:
                    <br>_____________ /____________________/</div>
                <div class="signature inline-block">Исполнитель:
                    <br>_____________ /____________________/</div>
            </div>


    </section>

</body>
