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
      font-family: 'DejaVu Sans', "Arial" !important;
    }

    body {
      font-size: 16px;
      line-height: 20px;
      margin: 0;
      font-family: 'DejaVu Sans', "Arial" !important;
      overflow-x: hidden;
      /* height: 842px; */
      /* width: 595px; */
      margin-left: auto;
      margin-right: auto;
    }

    /* .container {
      margin: 0px 20px;
    } */

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
        margin-top: 60px;
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

    .logo-block-image {
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
      right: 20px;
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

    section {
        margin: 0 10px
    }

    .table-materials {
        font-size: 9px;
    }

    .table-materials th {
      padding-left: 30px;
    }

</style>
</head>


<body>

  <header>
    <div class="logo-block">
      <img src="./img/logo-flat.svg" class="logo-block-image" alt="logo">
    </div>
  </header>

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
                @foreach ($order->rooms as $room)
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
                                <div class="room-features inline-block">
                                    <div class="info-item">S: {{ (float) $room->area }} м<sup>2</sup></div>
                                    <div class="info-item">H: {{ (float) $room->height }} м</div>
                                    <div class="info-item">S стен: {{ (float) $room->wall_area }} м<sup>2</sup></div>
                                    <div class="info-item">P: {{ (float) $room->perimeter }} м.п.</div>
                                </div>
                            @endif
                        </div>

                        @if ($room->room_services->count())
                            @foreach ( $room->room_services()->get()->groupBy(function($room_service) { return $room_service->service_type_id; }) as $service_type_id => $room_services)
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
                                            <td>{{ number_format((float) $room_service->quantity, 2, '.', '') }} м<sup>2</sup></td>
                                            
                                            @if ($order->discount)
                                                @if (\App\Models\Services\Service::where('id', $room_service->service_id)->first()->can_be_discounted)
                                                    <td>{{ \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price * (1 - $order->discount/100) }} Р/м<sup>2</sup></td>
                                                    <td>{{ number_format($room_service->quantity * \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price * (1 - $order->discount/100), 2, ',', ' ') }} Р</td>
                                                @else
                                                    <td>{{ \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price }} Р/м<sup>2</sup></td>
                                                    <td>{{ number_format($room_service->quantity * \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price, 2, ',', ' ') }} Р</td>
                                                @endif
                                            @endif
                                            @if ($order->markup)
                                                <td>{{ \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price * (1 + $order->markup/100) }} Р/м<sup>2</sup></td>
                                                <td>{{ number_format($room_service->quantity * \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price * (1 + $order->markup/100), 2, ',', ' ') }} Р</td>
                                            @endif
                                            @if ($order->discount === null && $order->markup === null)
                                                <td>{{ \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price }} Р/м<sup>2</sup></td>
                                                <td>{{ number_format($room_service->quantity * \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price, 2, ',', ' ') }} Р</td>
                                            @endif
                                        </tr>
                                    @endforeach

                                </table>
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
                    @if ($order->contract)
                        <span>Приложение к договору № {{ $order->contract }}</span>
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
