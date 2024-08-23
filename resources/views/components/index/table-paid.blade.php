@if (Auth::user()->hasAnyPermission($permissions))
    <button class="btn btn-sm btn-outline-primary" data-id={{ $id }} data-toggle="modal" data-target="#paidModal">
        Paid
    </button>    
@endif