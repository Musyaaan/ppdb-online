@if ($slot)
    <div class="alert-error animated-alert">
        <div class="alert-icon">
            !
        </div>

        <div class="alert-content">
            {{ $slot }}
        </div>
    </div>
@endif