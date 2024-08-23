<div id="{{ $id }}" class="container-fluid tab-pane @if ($attributes->has('active')) active @endif">
    {{ $slot }}
</div>
