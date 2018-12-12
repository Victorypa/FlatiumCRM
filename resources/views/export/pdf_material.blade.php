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

  <section class="print">
        <div class="container header-name">
            <div class="inline-block px-20">
                <h2 class="main-caption">
                    Ведомость объемов и стоимости работ
                </h2>
                <div class="info-wrapper">
                    <div class="inline-block">
                        <div class="main-info">Итого по смете: </div>
                        <div class="main-info">S объекта: </div>
                        <div class="main-info">Адрес: </div>

                        <div class="main-info">Заказчик: </div>
                        <div class="main-info">Менеджер: </div>
                    </div>
                    <div class="main-info-subtitles inline-block">
                        <div><b>{{ number_format($order->price, 2, ',', ' ') }} Р</b>@if ($order->discount) (с учётом скидки -{{ $order->discount }}%) @endif </div>
                        <div>{{ $total_area }} м² </div>
                        <div>{{ $order->address }}</div>
                        @if ($order->client_name)
                            <div> {{ $order->client_name }} </div>
                        @else
                            <div>&nbsp;</div>
                        @endif

                        @if ($order->manager)
                            <div>{{ $order->manager->name }} {{ $order->manager->phone }}</div>
                        @else
                            <div>
                                &nbsp;
                            </div>
                        @endif

                    </div>
                </div>
            </div>


            @if ($order->rooms)
                @foreach ($order->rooms()->orderBy('room_type_id')->get() as $room)
                    <div class="first-room">
                        <div class="first-room-top px-20">
                            <div class="main-subtitle pt-40 pb-20 inline-block">
                                @if ($room->description)
                                    {{ $room->description }}
                                @else
                                    {{ $room->roomType->type }}
                                @endif

                            </div>
                            @if ($room->room_type_id === 1)
                                @include('export.partials._room_details', [$room])
                            @endif
                        </div>

                        @if ($room->room_services->count())
                            @foreach ( $room->room_services()->orderBy('service_type_id')->get()->groupBy(function($room_service) { return $room_service->service_type_id; }) as $service_type_id => $room_services)
                                @include('export.partials._room_services', [$service_type_id, $room_services])
                            @endforeach
                        @endif
                    </div>
                @endforeach
            @endif


                <div class="value-materials-wrapper">
                    <div class="px-20 value-materials">
                        @if ($material_names)
                            <div class="main-subtitle col-10">
                                Предварительный расчет строительных материалов
                            </div>
                        @endif
                    </div>
                    <table>
                        @if ($material_names)
                            <tr>
                                <th class="table-subtitle">Наименование
                                </th>
                                <td class="table-subtitle">Кол-во</td>
                                <td class="table-subtitle">Цена</td>
                                <td class="table-subtitle">Стоимость</td>
                            </tr>

                            @foreach ($material_names as $id => $name)
                                <tr class="table-materials">
                                    <th class="table-materials-subtitle">{{ $name }}</th>
                                    @if ($material_quantites[$id] != 0)
                                        <td>{{ ceil($material_rates[$id] / $material_quantites[$id]) }} шт</td>
                                    @else
                                        <td>0 шт</td>
                                    @endif
                                    <td>{{ $material_prices[$id] }} Р</td>

                                    @if ($material_quantites[$id] != 0)
                                        <td>{{ number_format((int) ceil($material_rates[$id] / $material_quantites[$id]) * $material_prices[$id], 0, '', ' ') }} Р</td>
                                    @else
                                        <td>0 Р</td>
                                    @endif
                                </tr>
                            @endforeach

                            <tr class="borders">
                                <th class="table-caption full-summ-wrapper"></th>
                                <td class="material-summ full-summ-wrapper py-15" colspan="2">Итого по материалам:</td>
                                <td class="material-summ full-summ-wrapper material-summ-value py-15"> {{ number_format((int) $material_total_price, 0, '', ' ') }} Р</td>
                            </tr>
                        @endif


                        @if ($order->discount)
                            <tr class="borders">
                                <th class="table-caption full-summ-wrapper"></th>

                                <td class="table-caption full-summ full-summ-wrapper py-25">Итого:
                                    <br>
                                    <span>Скидка {{ $order->discount }}%</span>
                                </td>
                                <td class="table-caption full-summ full-summ-wrapper" colspan="2">{{ number_format((int) $order->original_price, 0, '', ' ') }} Р
                                    <br>
                                    <span>{{ number_format($order->price, 2, ',', ' ') }} Р</span>
                                </td>

                            </tr>
                        @endif

                        @if ($order->markup)
                            <tr class="borders">
                                <th class="table-caption full-summ-wrapper"></th>

                                <td class="table-caption full-summ full-summ-wrapper py-25">Итого:
                                </td>
                                <td class="table-caption full-summ full-summ-wrapper" colspan="2">{{ number_format((int) $order->price, 0, '', ' ') }} Р
                                </td>

                            </tr>
                        @endif

                        @if ($order->discount === null && $order->markup === null)
                            <tr class="borders">
                                <th class="table-caption full-summ-wrapper"></th>

                                <td class="table-caption full-summ full-summ-wrapper py-25">Итого:
                                </td>
                                <td class="table-caption full-summ full-summ-wrapper" colspan="2">{{ number_format((int)$order->price, 0, '', ' ') }} Р
                                </td>
                            </tr>
                        @endif
                    </table>

                </div>


            @include('export.partials._comment', [$order])

    </section>

</body>
