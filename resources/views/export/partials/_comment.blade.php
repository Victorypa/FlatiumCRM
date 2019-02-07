<div class="container">
    <div class="row">
        @if ($order->description)
            <strong>Комментарий:</strong>  {{ $order->description }}
        @endif
        <br>
    </div>
    <br><br>

    <div class="row">
            <div class="signature inline-block">Заказчик:
                <br>_____________ /____________________/
            </div>
            <div style="margin-left: 300px;" class="signature inline-block">Исполнитель:
                <br>_____________ /____________________/
            </div>
    </div>

</div>
