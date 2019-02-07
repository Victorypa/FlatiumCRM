<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Flatium</title>
    @include('export.partials._styles')
    <div id="header">
        <div class="page-number"></div>
    </div>
</head>


<body>
    <script type="text/php">
        if (isset($pdf)) {
            $text = "page {PAGE_NUM} / {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("Verdana");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>

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
                        <div class="main-info">Приложение к договору № </div>
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

                        @if ($order->contract)
                            <div>{{ $order->contract }}</div>
                        @else
                            <div>&nbsp;</div>
                        @endif

                    </div>
                </div>
            </div>

            @if ($order->rooms)
                @foreach ($order->rooms()->where('room_type_id', '!=', 4)->orderBy('priority', 'asc')->orderBy('room_type_id')->get() as $index => $room)
                    <div class="first-room" style="margin-top: 30px;">
                        <div class="first-room-top px-20 border-black">
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

                        <div class="first-room-top background-solid"></div>

                        @if ($room->room_services->count())
                            @foreach ( $room->room_services()->orderBy('created_at', 'asc')->orderBy('service_type_id', 'asc')->get()->groupBy(function($room_service) { return $room_service->service_type_id; }) as $service_type_id => $room_services)
                                @include('export.partials._room_services', [$service_type_id, $room_services])
                            @endforeach
                        @endif

                        <table>
                            <tr class="borders">
                                <th class="table-caption"></th>
                                <td class="table-caption"></td>
                                <td class="table-caption"></td>
                                <td class="table-caption">
                                    <strong class="font-size-fix"><b>{{ number_format($room->price, 0, ',', ' ') }} Р</b></strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                @endforeach
            @endif

            <div class="value-materials-wrapper">
                @if ($order->discount)
                    <table class="border-free">
                        <tr class="border-free">
                            <th class="table-caption border-free background-free"></th>

                            <td class="py-25 table-caption border-free ml-20"><strong><b>ИТОГО:</b></strong>
                                <br>
                                <span class="font-size-fix">Скидка {{ $order->discount }}%</span>
                            </td>
                            <td class="table-caption border-free ml-15" colspan="2">
                                <strong class="font-size-fix"><b>{{ number_format((int) $order->original_price, 0, '', ' ') }} Р</b></strong>
                                <strong class="font-size-fix"><b>{{ number_format((int) $order->price, 0, '', ' ') }} Р</b></strong>
                            </td>

                        </tr>
                    </table>
                @endif

                @if ($order->markup)
                    <table class="border-free">
                        <tr class="border-free">
                            <th class="table-caption border-free background-free"></th>

                            <td class="py-25 table-caption border-free ml-20"><strong><b>ИТОГО:</b></strong></td>

                            <td class="table-caption border-free ml-15 font-size-fix" colspan="2">{{ number_format((int) $order->price, 0, '', ' ') }} Р
                            </td>

                        </tr>
                    </table>
                @endif

                @if ($order->discount === null && $order->markup === null)
                  <div class="container">
                      <div class="row">
                          <strong><b>
                              ИТОГО ПО ВЕДОМОСТИ И СТОИМОСТИ РАБОТ:
                              {{ number_format($order->price, 0, '', ' ') }} Р
                          </b></strong>
                      </div>
                    {{-- <table class="border-free">
                        <tr class="border-free">
                            <th class="table-caption border-free background-free"></th>
                            <td class="py-25 table-caption border-free"><strong><b>ИТОГО ПО ВЕДОМОСТИ И СТОИМОСТИ РАБОТ:</b></strong></td>
                            <td class="table-caption border-free ml-15 font-size-fix" colspan="2"><strong><b>{{ number_format($order->price, 0, '', ' ') }} Р</b></strong></td>
                        </tr>
                    </table> --}}
                  </div>
                @endif
            </div>

            <div class="container header-name">
              @if ($order->rooms)
                  @foreach ($order->rooms()->where('room_type_id', 4)->orderBy('room_type_id')->get() as $room)
                      <div class="first-room" style="margin-top: 30px;">
                          <div class="first-room-top px-20 border-black">
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

                          <div class="first-room-top background-solid"></div>

                          @if ($room->room_services->count())
                              @foreach ( $room->room_services()->orderBy('created_at', 'asc')->orderBy('service_type_id', 'asc')->get()->groupBy(function($room_service) { return $room_service->service_type_id; }) as $service_type_id => $room_services)
                                  @include('export.partials._room_services', [$service_type_id, $room_services])
                              @endforeach
                          @endif

                          <table>
                              <tr class="borders">
                                  <th class="table-caption"></th>
                                  <td class="table-caption"></td>
                                  <td class="table-caption"></td>
                                  <td class="table-caption">
                                      <strong class="font-size-fix"><b>{{ number_format($room->price, 0, ',', ' ') }} Р</b></strong>
                                  </td>
                              </tr>
                          </table>

                          {{-- <div class="container">
                            <table class="border-free">
                                <tr class="border-free">
                                    <th class="table-caption border-free background-free"></th>
                                    <td class="py-25 table-caption border-free ml-20"><strong><b>ИТОГО ПО РЕКОМЕНДУЕМЫМ РАБОТАМ:</b></strong></td>
                                    <td class="table-caption border-free ml-15 font-size-fix" colspan="2"><strong><b>{{ number_format($room->price, 0, ',', ' ') }} Р</b></strong></td>
                                </tr>
                            </table>
                          </div> --}}
                      </div>
                  @endforeach
              @endif

              @include('export.partials._comment', [$order])

            </div>
    </section>
</body>

</html>
