<div class="room-features inline-block">
    @if ($room->area != 0)
        <div class="info-item">S: {{ (float) $room->area }} м<sup>2</sup></div>
    @endif

    @if ($room->height != 0)
        <div class="info-item">H: {{ (float) $room->height }} м</div>
    @endif

    @if ($room->wall_area != 0)
        <div class="info-item">S стен: {{ (float) $room->wall_area }} м<sup>2</sup></div>
    @endif

    @if ($room->perimeter != 0)
        <div class="info-item">P: {{ (float) $room->perimeter }} м.п.</div>
    @endif
</div>
