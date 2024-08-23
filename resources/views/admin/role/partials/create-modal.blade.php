<form id="form">
    <div class="modal fade" id="modal-create" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('home.add') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">บทบาท</label>
                        <input class="form-control " name="name" id="name" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">คำอธิบาย</label>
                        <input class="form-control " name="description" id="description" />
                    </div>
                    <div class="mb-3">

                        <label class="form-label">การเข้าถึง</label>

                        @foreach ($permissions->groupBy('group') as $key => $group_permission)
                            <div class="card card-default">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $key }}</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($group_permission as $permission)
                                            @if ($permission->group == $key)
                                                <div class="col-sm-3">
                                                    <label class="switch2 mr-2"> <input type="checkbox" value="1"
                                                            id="" name="publish_map"> <span
                                                            class="slider2 "></span>
                                                    </label>
                                                    <span class="">{{ $permission->name }}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- <div class="mb-3">
                        <label class="form-label">การเข้าถึง</label>
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="col-sm-2">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="someCheckboxId{{ ' ' . $permission->id }}" />
                                        <label
                                            for="someCheckboxId{{ ' ' . $permission->id }}">{{ $permission->description }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div> --}}
                    {{-- <div class="mb-3">
                        <label class="form-label">การเข้าถึง</label>
                        <select class="select2 form-control" name="permission" id="permission" style="width: 100%;"
                            multiple>
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->description }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('home.close') }}</button>
                    <button type="reset" class="btn btn-danger">{{ __('home.reset') }}</button>
                    <a class="btn {{ env('BTN_THEME') }}" onclick="storeData()">{{ __('home.save') }}</a>
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
