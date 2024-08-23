<div class="col-sm-12 ml-1 text-bold mb-1" style="font-size: 20px;">
    <i class="far fa-pen text-muted mr-2"></i> @if($attributes->has('page')){{ $page }}@endif
</div>
<div class="row">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: transparent;">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" class="{{ env('TEXT_THEME') }}">
                <i class="fa fa-home fa-fw" aria-hidden="true"></i> หน้าแรก</a></li>
            @if ($attributes->has('page'))
            <li class="breadcrumb-item active">{{ $page }}</li>
            @endif
        </ol>
    </nav>
</div>
