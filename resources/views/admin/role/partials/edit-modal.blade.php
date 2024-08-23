<form id="form">
    <div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">แก้ไขข้อมูล</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="eid">
                    <div class="mb-3">
                        <label class="form-label">บทบาท</label>
                        <input class="form-control " name="name" id="ename" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">คำอธิบาย</label>
                        <input class="form-control " name="description" id="edescription" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">การเข้าถึง</label>
                        <select class="select2 form-control" name="permission" id="epermission" style="width: 100%;"
                            multiple>
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('home.close') }}</button>
                    <button type="reset" class="btn btn-danger">{{ __('home.reset') }}</button>
                    <a class="btn {{ env('BTN_THEME') }}" onclick="updateData()">{{ __('home.save') }}</a>
                </div>
            </div>
        </div>
    </div>
</form>


@push('js')
    <script>
        $(document).ready(function() {});
    </script>
@endpush
