{{-- Krajee --}}
{{-- @php
    $config = [
        'browseOnZoneClick' => true,
        'overwriteInitial' => true,
        'theme' => 'fa5',
        'language' => 'th',
        'showUpload' => false,
        'allowedFileExtensions' => ["jpg", "jpeg", "gif", "png"],
    ];
@endphp --}}

<form id="form">
    <div class="modal fade" id="modal-create" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('home.add') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <div class="mb-3 text-center">
                                    <label class="form-label">{{ __('user.profile_picture') }}</label><br />
                                    <img src="https://placehold.co/300x300" id="showimg" width="150" height="150"
                                        style="max-width: 100%; object-fit: cover;"> <br />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="img" name="img"
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
                                        <input class="form-control " name="firstname_th" id="firstname_th" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('user.last_name') }}</label>
                                        <input class="form-control " name="lastname_th" id="lastname_th" />
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('user.phone_number') }}</label>
                                        <input type="text" class="form-control  inputmask-phone" name="phone"
                                            id="phone">
                                    </div>
                                </div>
                                {{-- <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Line ID</label>
                                        <input type="text" class="form-control " name="line_id"
                                            id="line_id">
                                    </div>
                                </div> --}}
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('user.role') }}</label>
                                        <select class="select2 form-control" name="role" id="role"
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

                                <input type="email" class="form-control " name="email" id="email"
                                    onchange="checkEmail()" />
                                <div id="email-valid-feedback"></div>

                            </div>
                            <div class="row">
                                {{-- <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="username" class="form-control " name="username"
                                            id="username" onchange="checkUsername()" />
                                        <div id="username-valid-feedback"></div>
                                    </div>
                                </div> --}}
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('user.password') }}</label>
                                        <input type="password" class="form-control " name="password" id="password" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('home.close') }}</button>
                    <button type="reset" class="btn btn-danger btnReset">{{ __('home.reset') }}</button>
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
