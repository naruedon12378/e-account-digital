<style>
    #progress .info-box {
        min-height: 50px !important;
        margin-right: 1rem;
    }

    #progress .info-box .info-box-icon {
        width: 25px !important;
        font-size: 1rem !important;
    }
</style>
<div id="progress" class="d-flex justify-content-center flex-wrap">
    @foreach ($progress as $key => $value)
        <div class="info-box"
            style="width:@if (count($progress) > 5) 170px !important; @else 200px !important; @endif">
            <span class="info-box-icon">
                @if ($key < $active)
                    <i class="fa-regular fa-circle-check"></i>
                @elseif ($key == $active)
                    <i class="fa-solid fa-spinner"></i>
                @else
                    <i class="fa-regular fa-circle"></i>
                @endif
            </span>
            <div class="info-box-content">
                <span class="info-box-text">{{ __($file . '.' . $value) }}</span>
            </div>
        </div>
    @endforeach
</div>
