<form id="form">
    <div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('home.edit') }}</h5>
                    <div class="ml-3" id="btnDel"></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="eid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <div class="mb-3 text-center">
                                    <label class="form-label">{{ __('user.profile_picture') }}</label><br />
                                    <img src="https://placehold.co/300x300" id="eshowimg" width="150" height="150"
                                        style="max-width: 100%; object-fit: cover;"> <br />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="eimg" name="eimg"
                                            onchange="return fileValidation(this)" accept="image/*">
                                        <label class="custom-file-label">{{ __('user.choose_file') }}</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-6">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('user.first_name') }}</label>
                                        <input class="form-control " name="efirstname" id="efirstname" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('user.last_name') }}</label>
                                        <input class="form-control " name="elastname" id="elastname" />
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('user.phone_number') }}</label>
                                        <input type="text" class="form-control  inputmask-phone" name="ephone"
                                            id="ephone">
                                    </div>
                                </div>
                                {{-- <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Line ID</label>
                                        <input type="text" class="form-control " name="eline_id"
                                            id="eline_id">
                                    </div>
                                </div> --}}
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('user.role') }}</label>
                                        <select class="select2 form-control" name="erole" id="erole"
                                            style="width: 100%;">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6">

                            <div class="mb-3">
                                <label class="form-label">{{ __('user.email') }}</label>
                                <input type="email" class="form-control " name="eemail" id="eemail" />
                            </div>
                            <div class="row">
                                {{-- <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="username" class="form-control " name="eusername"
                                            id="eusername" />
                                    </div>
                                </div> --}}
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('user.password') }}</label>
                                        <input type="password" class="form-control " name="epassword" id="epassword" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('home.close') }}</button>
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
