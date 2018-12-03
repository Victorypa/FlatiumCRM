<html>
    <head>
         <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <table>
            <tr>
                <td>Ведомость объемов и стоимости работ</td>
                <td colspan="3"><p>Flatium</p></td>
            </tr>

            <tr>
                <td>Заказчик: @if ($order->client_name) {{ $order->client_name }} @endif</td>
            </tr>
            <tr>
                <td>Адрес: {{ $order->address }}</td>
            </tr>
            <tr>
                <td>Менеджер: @if ($order->manager) {{ $order->manager->name }} {{ $order->manager->phone }} @endif</td>
            </tr>
            <tr>
                <td> -{{ $order->rooms->where('room_type_id', 1)->count() }} комнатной квартиры м.кв</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Наименование</td>
                <td>Ед.изм.</td>
                <td>Кол-во</td>
                <td>Цена</td>
                <td>Стоимость </td>

            </tr>
            <tr>
                <td>(1) м.кв</td>
            </tr>
            <tr>
                <td>длина</td>
            </tr>
            <tr>
                <td>ширина</td>
            </tr>
            <tr>
                <td>высота потолка</td>
                <td>м</td>
            </tr>
            <tr>
                <td>площадь</td>
                <td>м.кв</td>
            </tr>
            <tr>
                <td>периметр</td>
                <td>м</td>
            <tr>
                <td>площадь стен</td>
                <td>м.кв</td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>



            @if ($order->rooms->count())
                @foreach ($order->rooms as $room)
                    <tr>
                        <td>
                            @if ($room->description)
                                {{ $room->description }}
                            @else
                                {{ $room->roomType->type }}
                            @endif
                        </td>
                        @if ($room->room_type_id === 1)
                            <td>S: {{ (float) $room->area }} м<sup>2</sup></td>
                            <td>H: {{ (float) $room->height }} м</td>
                            <td>S стен: {{ (float) $room->wall_area }} м<sup>2</sup></td>
                            <td>P: {{ (float) $room->perimeter }} м.п.</td>
                        @else
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        @endif
                    </tr>

                    @if ($room->room_services->count())
                        @foreach ( $room->room_services()->get()->groupBy(function($room_service) { return $room_service->service_type_id; }) as $service_type_id => $room_services)
                            <tr>
                                <td></td>
                                <td>Ед.изм.</td>
                                <td>Кол-во</td>
                                <td>Цена</td>
                                <td>Стоимость</td>
                            </tr>
                            <tr>
                                <td>{{ \App\Models\Services\ServiceType::where('id', $service_type_id)->first()->name }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @foreach ($room_services as $room_service)
                                <tr>
                                    <td>{{ \App\Models\Services\Service::where('id', $room_service->service_id)->first()->name }}</td>
                                    <td>{{ \App\Models\Units\Unit::where('id', $room_service->service_unit_id)->first()->name }}</td>
                                    <td>{{ number_format((float) $room_service->quantity, 2, '.', '') }}</td>
                                    @if ($order->discount)
                                        @if (\App\Models\Services\Service::where('id', $room_service->service_id)->first()->can_be_discounted)
                                            <td>{{ \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price * (1 - $order->discount/100) }} Р</td>
                                            <td>{{ number_format($room_service->quantity * \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price * (1 - $order->discount/100), 2, ',', ' ') }} Р</td>
                                        @else
                                            <td>{{ \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price }} Р</td>
                                            <td>{{ number_format($room_service->quantity * \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price, 2, ',', ' ') }} Р</td>
                                        @endif
                                    @endif
                                    @if ($order->markup)
                                        <td>{{ \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price * (1 + $order->markup/100) }} Р</td>
                                        <td>{{ number_format($room_service->quantity * \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price * (1 + $order->markup/100), 2, ',', ' ') }} Р</td>
                                    @endif
                                    @if ($order->discount === null && $order->markup === null)
                                        <td>{{ \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price }} Р</td>
                                        <td>{{ number_format($room_service->quantity * \App\Models\Services\Service::where('id', $room_service->service_id)->first()->price, 2, ',', ' ') }} Р</td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                    @endif
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            @endif

            {{-- <tr>
                <td>ИТОГО</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Работы не вошедшие в смету</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>0</td>
            </tr>
            <tr>
                <td>ИТОГО</td>
                <td></td>
                <td></td>
                <td></td>
                <td>0</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>ИТОГО по всем работам</td>
                <td></td>
                <td></td>
                <td></td>
                <td>0</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Преимущества работы с нами:</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>1. Закрепление руководителя проекта для оперативного решения возникающих вопросов.</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>2. Еженедельный аудит отделом качества объекта для оценки выполняемых работ.</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>3. Фиксирование точной стоимости работ в договоре перед началом работ. Стоимость в течение проекта не меняется.</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>4. Фиксирование в договоре сроков окончания работ, с указанием штрафных санкций со стороны компании при их несоблюдении.</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>5. Возможность интерактивно (онлайн) наблюдать за продвижением работ над проектом.</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>6. Поэтапная сдача проекта с подписанием актов, при согласования качества выполненных работ с заказчиком.</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>7. Гарантия на выполненные работы 2 года.</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>8. Гибкая поэтапная система оплаты.</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>9. Предоставление всех платежных документов. </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>10. 100% прозрачность ведения проекта для заказчика.</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>P. S.: Будем рады работать для Вас.</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>С уважением,</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>руководитель проектов</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr> --}}


        </table>
    </body>
</html>
