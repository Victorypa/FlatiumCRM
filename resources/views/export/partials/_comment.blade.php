<div class="container">
    <div>
        @if ($order->description)
            <strong>Комментарий:</strong>  {{ $order->description }}
        @endif
        <br>
    </div>
</div>
<br><br>
<div class="container">
    <div class="signature inline-block">Заказчик:
        <br>_____________ /____________________/</div>
    <div class="signature inline-block">Исполнитель:
        <br>_____________ /____________________/</div>
</div>
