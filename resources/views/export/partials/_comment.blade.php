<div class="row">
    @if ($order->description)
        <strong>Комментарий:</strong>  {{ $order->description }}
    @endif
    <br>
</div>
<br>

<div class="row">
        <div class="signature inline-block">Заказчик:
            <br>_____________ /____________________/
        </div>
        <div style="margin-left: 200px;" class="signature inline-block">Исполнитель:
            <br>_____________ /____________________/
        </div>
</div>
