<div class="container comment">
    <div>
        @if ($order->description)
            <strong>Комментарий:</strong>  {{ $order->description }}
        @endif
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
