<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Flatium</title>

    <style>
    .page-break {
        page-break-after: always;
    }

    * {
        font-family: 'Dejavu Sans', "Arial" !important;
    }

    @page {
        margin: 0;
    }

    html,
body {
height: 100%;
}

body {
font-size: 16px;
line-height: 20px;
margin: 0;
font-family: "Arial";
overflow-x: hidden;
/* height: 842px; */
/* width: 595px; */
margin-left: auto;
margin-right: auto;
}

/* .container {
margin: 0px 20px;
} */

section {
margin: 0 10px;
}

.px-20 {
padding: 0 20px;
}

.pt-25 {
padding-top: 25px;
}

.pt-35 {
padding-top: 35px;
}

.pt-40 {
padding-top: 40px;
}

.pb-20 {
padding-bottom: 20px;
}

.py-25 {
padding-top: 25px;
padding-bottom: 25px;
}

.py-15 {
padding-top: 15px;
padding-bottom: 15px;
}

.mb-40 {
margin-bottom: 40px;
}

a {
color: #000;
}

.w-50 {
width: 50%;
}

header {
width: 100%;
background-color: #00a4d1;
height: 50px;
}

.header-name {
margin-top: 80px;
}

.inline-block {
display: inline-block;
}

.info-wrapper {
font-size: 13px;
}

.logo-block {
width: 90px;
margin-left: 20px;
padding: 10px 0;
}

.logo-block img {
height: 30px;
}

.header img {
width: 100%;
height: 100%;
}

.main-caption {
font-size: 17px;
/* line-height: 50px; */
margin-bottom: 40px;
}

.main-caption-width {
width: 60%;
}

.main-info {
color: #666;
}

.main-info-subtitles {
padding-left: 30px;
}

.first-room-top,
.second-room-top,
.value-materials {
border: 1px solid #ebebeb;
position: relative;
}

.main-subtitle {
font-size: 16px;
font-weight: bold;
}

.main-subtitle span {
color: #666;
font-weight: 400;
}

.main-subtitle span:not(:first-child) {
padding-left: 15px;
}

th {
font-weight: normal;
width: 35%;
}

td {
width: 7%;
}

table {
width: 100%;
border-collapse: collapse;
font-size: 10px;
}

td,
th {
text-align: left;
background-color: #f2f4f5;
border-bottom: 1px solid #fff;
color: #777777;
padding: 4px 0;
padding-left: 20px;
}

td:first-child,
th:first-child {
padding-left: 20px;
}

.borders {
border-left: 1px solid #ebebeb;
border-right: 1px solid #ebebeb;
}

.comment {
font-size: 8px;
font-weight: 400;
color: #666;
padding-top: 40px;
padding-bottom: 65px;
width: 70%;
margin: 0px 20px;
}

.comment span {
color: #888888;
}

.signature {
font-size: 10px;
font-weight: bold;
width: 35%;
}

.signature-item {
padding-bottom: 100px;
margin: 0px 20px;
}

.info-item {
display: inline-block;
margin-right: 5px;
margin-left: 0.5rem;
}

.info-item span {
font-weight: bold;
}

.room-features {
font-size: 12px;
padding-bottom: 20px;
position: absolute;
right: 10px;
top: 35px;
}

.table-caption {
font-size: 14px;
font-weight: 400;
background-color: #fff;
color: #000;
}

.table-subtitle {
font-size: 11px;
font-weight: bold;
color: #000;
}

.table-materials {
font-size: 9px;
}

.table-materials th:first-child {
padding-left: 30px;
}

.material-summ {
font-size: 10px;
color: #545454;
font-weight: bold;
background-color: #fff;
}

.material-summ-value {
color: #666;
font-size: 10px;
}

.full-summ {
font-weight: bold;
}

.full-summ span {
font-size: 10px;
color: #545454;
}

.full-summ-wrapper {
border-bottom: 1px solid #ebebeb;
}

.full-summ-wrapper td {
padding-top: 35px;
padding-bottom: 35px;
}

.bb {
border-bottom: 1px solid #ebebeb;
}
    </style>
</head>

<body>
    <header>
      <div class="logo-block">
        <img src="./img/logo-flat.svg" alt="logo">
      </div>
    </header>

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
                        <div><b>{{ number_format($filteredExtraOrder->price, 2, ',', ' ') }} Р</b> @if ($filteredExtraOrder->order->discount) (с учётом скидки -{{ $filteredExtraOrder->order->discount }}%) @endif </div>
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
                            <div class="room-features inline-block">
                                <div class="info-item">S: {{ $extra_room->room->area }} м<sup>2</sup></div>
                                <div class="info-item">H: {{ $extra_room->room->height }} м</div>
                                <div class="info-item">S стен: {{ $extra_room->room->wall_area }} м<sup>2</sup></div>
                                <div class="info-item">P: {{ $extra_room->room->perimeter }} м.п.</div>
                            </div>
                        @endif

                    </div>

                    @if ($extra_room->room->room_type_id === 1)
                        @if ($extra_room->extra_services->where('service_type_id', 1)->count())
                            <table class="floor">
                                <tr>
                                    <th class="table-subtitle">Наименование
                                    </th>
                                    <td class="table-subtitle">Кол-во</td>
                                    <td class="table-subtitle">Цена</td>
                                    <td class="table-subtitle">Стоимость</td>
                                </tr>
                                <tr class="borders">
                                    <th class="table-caption">Пол
                                    </th>
                                    <td class="table-caption"></td>
                                    <td class="table-caption"></td>
                                    <td class="table-caption"></td>
                                </tr>
                                @foreach ($extra_room->extra_services->where('service_type_id', 1) as $service)
                                    <tr>
                                        <th>{{ $service->name }}</th>
                                        <td>{{ $service->pivot->quantity }} м<sup>2</sup></td>

                                        @if ($filteredExtraOrder->order->discount)
                                            @if ($service->can_be_discounted)
                                                <td>{{ $service->price * (1 - $filteredExtraOrder->order->discount/100) }} Р/м<sup>2</sup></td>
                                                <td>{{ number_format($service->pivot->quantity * $service->price * (1 - $filteredExtraOrder->order->discount/100), 2, ',', ' ') }} Р</td>
                                            @else
                                                <td>{{ $service->price }} Р/м<sup>2</sup></td>
                                                <td>{{ number_format($service->pivot->quantity * $service->price, 2, ',', ' ') }} Р</td>
                                            @endif
                                        @endif

                                        @if ($filteredExtraOrder->order->markup)
                                            <td>{{ $service->price * (1 + $filteredExtraOrder->order->markup/100) }} Р/м<sup>2</sup></td>
                                            <td>{{ number_format($service->pivot->quantity * $service->price * (1 + $filteredExtraOrder->order->markup/100), 2, ',', ' ') }} Р</td>
                                        @endif

                                        @if ($filteredExtraOrder->order->discount === null && $filteredExtraOrder->order->markup === null )
                                            <td>{{ $service->price }} Р/м<sup>2</sup></td>
                                            <td>{{ number_format($service->pivot->quantity * $service->price, 2, ',', ' ') }} Р</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                        @endif


                        @if ($extra_room->extra_services->where('service_type_id', 2)->count())
                            <table class="wall pt-25">
                            <tr class="borders">
                                <th class="table-caption">Стены
                                </th>
                                <td class="table-caption"></td>
                                <td class="table-caption"></td>
                                <td class="table-caption"></td>
                            </tr>
                            @foreach ($extra_room->extra_services->where('service_type_id', 2) as $service)
                                <tr>
                                    <th>{{ $service->name }}</th>
                                    <td>{{ $service->pivot->quantity }} м<sup>2</sup></td>

                                    @if ($filteredExtraOrder->order->discount)
                                        @if ($service->can_be_discounted)
                                            <td>{{ $service->price * (1 - $filteredExtraOrder->order->discount/100) }} Р/м<sup>2</sup></td>
                                            <td>{{ number_format($service->pivot->quantity * $service->price * (1 - $filteredExtraOrder->order->discount/100), 2, ',', ' ') }} Р</td>
                                        @else
                                            <td>{{ $service->price }} Р/м<sup>2</sup></td>
                                            <td>{{ number_format($service->pivot->quantity * $service->price, 2, ',', ' ') }} Р</td>
                                        @endif
                                    @endif

                                    @if ($filteredExtraOrder->order->markup)
                                        <td>{{ $service->price * (1 + $filteredExtraOrder->order->markup/100) }} Р/м<sup>2</sup></td>
                                        <td>{{ number_format($service->pivot->quantity * $service->price * (1 + $filteredExtraOrder->order->markup/100), 2, ',', ' ') }} Р</td>
                                    @endif

                                    @if ($filteredExtraOrder->order->discount === null && $filteredExtraOrder->order->markup === null )
                                        <td>{{ $service->price }} Р/м<sup>2</sup></td>
                                        <td>{{ number_format($service->pivot->quantity * $service->price, 2, ',', ' ') }} Р</td>
                                    @endif
                                </tr>
                            @endforeach

                        </table>
                        @endif


                        @if ($extra_room->extra_services->where('service_type_id', 3)->count())
                            <table class="wall pt-25">
                            <tr class="borders">
                                <th class="table-caption">Потолок
                                </th>
                                <td class="table-caption"></td>
                                <td class="table-caption"></td>
                                <td class="table-caption"></td>
                            </tr>
                            @foreach ($extra_room->extra_services->where('service_type_id', 3) as $service)
                                <tr>
                                    <th>{{ $service->name }}</th>
                                    <td>{{ $service->pivot->quantity }} м<sup>2</sup></td>

                                    @if ($filteredExtraOrder->order->discount)
                                        @if ($service->can_be_discounted)
                                            <td>{{ $service->price * (1 - $filteredExtraOrder->order->discount/100) }} Р/м<sup>2</sup></td>
                                            <td>{{ number_format($service->pivot->quantity * $service->price * (1 - $filteredExtraOrder->order->discount/100), 2, ',', ' ') }} Р</td>
                                        @else
                                            <td>{{ $service->price }} Р/м<sup>2</sup></td>
                                            <td>{{ number_format($service->pivot->quantity * $service->price, 2, ',', ' ') }} Р</td>
                                        @endif
                                    @endif

                                    @if ($filteredExtraOrder->order->markup)
                                        <td>{{ $service->price * (1 + $filteredExtraOrder->order->markup/100) }} Р/м<sup>2</sup></td>
                                        <td>{{ number_format($service->pivot->quantity * $service->price * (1 + $filteredExtraOrder->order->markup/100), 2, ',', ' ') }} Р</td>
                                    @endif

                                    @if ($filteredExtraOrder->order->discount === null && $filteredExtraOrder->order->markup === null )
                                        <td>{{ $service->price }} Р/м<sup>2</sup></td>
                                        <td>{{ number_format($service->pivot->quantity * $service->price, 2, ',', ' ') }} Р</td>
                                    @endif
                                </tr>
                            @endforeach

                        </table>
                        @endif

                    @endif

                    @if ($extra_room->extra_services->where('service_type_id', 4)->count())
                        <table class="floor">
                            <tr>
                                <th class="table-subtitle">Наименование
                                </th>
                                <td class="table-subtitle">Кол-во</td>
                                <td class="table-subtitle">Цена</td>
                                <td class="table-subtitle">Стоимость</td>
                            </tr>
                            @foreach ($extra_room->extra_services->where('service_type_id', 4) as $service)
                                <tr>
                                    <th>{{ $service->name }}</th>
                                    <td>{{ $service->pivot->quantity }} м<sup>2</sup></td>

                                    @if ($filteredExtraOrder->order->discount)
                                        @if ($service->can_be_discounted)
                                            <td>{{ $service->price * (1 - $filteredExtraOrder->order->discount/100) }} Р/м<sup>2</sup></td>
                                            <td>{{ number_format($service->pivot->quantity * $service->price * (1 - $filteredExtraOrder->order->discount/100), 2, ',', ' ') }} Р</td>
                                        @else
                                            <td>{{ $service->price }} Р/м<sup>2</sup></td>
                                            <td>{{ number_format($service->pivot->quantity * $service->price, 2, ',', ' ') }} Р</td>
                                        @endif
                                    @endif

                                    @if ($filteredExtraOrder->order->markup)
                                        <td>{{ $service->price * (1 + $filteredExtraOrder->order->markup/100) }} Р/м<sup>2</sup></td>
                                        <td>{{ number_format($service->pivot->quantity * $service->price * (1 + $filteredExtraOrder->order->markup/100), 2, ',', ' ') }} Р</td>
                                    @endif

                                    @if ($filteredExtraOrder->order->discount === null && $filteredExtraOrder->order->markup === null )
                                        <td>{{ $service->price }} Р/м<sup>2</sup></td>
                                        <td>{{ number_format($service->pivot->quantity * $service->price, 2, ',', ' ') }} Р</td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                    @endif

                    @if ($extra_room->extra_services->where('service_type_id', 5)->count())
                        <table class="floor">
                            <tr>
                                <th class="table-subtitle">Наименование
                                </th>
                                <td class="table-subtitle">Кол-во</td>
                                <td class="table-subtitle">Цена</td>
                                <td class="table-subtitle">Стоимость</td>
                            </tr>
                            @foreach ($extra_room->extra_services->where('service_type_id', 5) as $service)
                                <tr>
                                    <th>{{ $service->name }}</th>
                                    <td>{{ $service->pivot->quantity }} м<sup>2</sup></td>

                                    @if ($filteredExtraOrder->order->discount)
                                        @if ($service->can_be_discounted)
                                            <td>{{ $service->price * (1 - $filteredExtraOrder->order->discount/100) }} Р/м<sup>2</sup></td>
                                            <td>{{ number_format($service->pivot->quantity * $service->price * (1 - $filteredExtraOrder->order->discount/100), 2, ',', ' ') }} Р</td>
                                        @else
                                            <td>{{ $service->price }} Р/м<sup>2</sup></td>
                                            <td>{{ number_format($service->pivot->quantity * $service->price, 2, ',', ' ') }} Р</td>
                                        @endif
                                    @endif

                                    @if ($filteredExtraOrder->order->markup)
                                        <td>{{ $service->price * (1 + $filteredExtraOrder->order->markup/100) }} Р/м<sup>2</sup></td>
                                        <td>{{ number_format($service->pivot->quantity * $service->price * (1 + $filteredExtraOrder->order->markup/100), 2, ',', ' ') }} Р</td>
                                    @endif

                                    @if ($filteredExtraOrder->order->discount === null && $filteredExtraOrder->order->markup === null )
                                        <td>{{ $service->price }} Р/м<sup>2</sup></td>
                                        <td>{{ number_format($service->pivot->quantity * $service->price, 2, ',', ' ') }} Р</td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                    @endif
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
                                {{ number_format($filteredExtraOrder->order->original_price, 2, ',', ' ') }} Р
                                <br>
                                <span>{{ number_format($filteredExtraOrder->order->price, 2, ',', ' ') }} Р</span>
                            </td>
                        @else
                            <td class="table-caption full-summ full-summ-wrapper" colspan="2">
                                {{ number_format($filteredExtraOrder->order->price, 2, ',', ' ') }} Р
                                <br>
                                <span>&nbsp;</span>
                            </td>
                        @endif
                    </tr>
                </table>

            </div>

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

                    @if ($filteredExtraOrder->order->contract)
                        <span>Приложение к договору № {{ $filteredExtraOrder->order->contract }}</span>
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
