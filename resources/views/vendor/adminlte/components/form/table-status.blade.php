@if ($data['isActive'])
    {{-- <label class="switch"> <input type="checkbox" checked value="0"
        onchange="publish('{{ url($url) }}')"> <span class="slider round"></span>
    </label> --}}
    {{-- <div class="custom-control custom-switch">
    </div> --}}
    <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="customSwitch1" checked value="0"
            onchange="publish('{{ url($url) }}')">
        <label class="custom-control-label" for="customSwitch1"></label>
    </div>
@else
    <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="customSwitch2" value="1"
            onchange="publish('{{ url($url) }}')">
        <label class="custom-control-label" for="customSwitch2"></label>
    </div>
@endif

@if (Auth::user()->hasRole($role))
    @if ($data['isActive'])
        <span class="badge badge-success">เผยแพร่</span>
    @else
        <span class="badge badge-danger">ไม่เผยแพร่</span>
    @endif
@endif
