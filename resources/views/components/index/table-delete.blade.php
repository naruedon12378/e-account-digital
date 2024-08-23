@if (Auth::user()->hasAnyPermission($permissions))
    <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete('{{ url($url) }}')">
        <i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i>
    </button>    
@endif

        
