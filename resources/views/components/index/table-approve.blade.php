@if (Auth::user()->hasAnyPermission($permissions))
    <x-button-group label="Approve" color="info" class="btn-sm">
        <a class="dropdown-item" href="javascript:;">
            Approve and print
        </a>
        <a class="dropdown-item" href="javascript:;">
            Approve and create new
        </a>
        <a class="dropdown-item" href="javascript:;">
            Send for Approval
        </a>
    </x-button-group>
@endif

{{-- <div class="btn-group">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">Action
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
        <li>
            <button="type" class="btn btn-link view"><i class="fa fa-eye"></i>
            View</button>
        </li>
        <li>
            <a href="'.route('products.edit', $product->id).'" class="btn btn-link">
                <i class="fa fa-edit"></i>Edit</a>
        </li>
    </ul>
</div> --}}
