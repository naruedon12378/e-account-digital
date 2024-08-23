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
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
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
                                <blockquote class="quote-primary text-md" style="margin: 0 !important;">
                                    {{ __('package_manage.package_information') }}
                                </blockquote>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('package_manage.package_name_th') }}</label>
                                <input class="form-control " name="name_th" id="name_th" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('package_manage.package_name_en') }}</label>
                                <input class="form-control " name="name_en" id="name_en" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('package_manage.description_th') }}</label>
                                <textarea class="form-control " name="description_th" id="description_th" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('package_manage.description_en') }}</label>
                                <textarea class="form-control " name="description_en" id="description_en" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('package_manage.price') }}</label>
                                <input type="number" class="form-control " name="price" id="price" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('package_manage.discount') }}</label>
                                <input type="number" class="form-control " name="discount" id="discount" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('package_manage.user_limit') }}</label>
                                <input type="number" class="form-control " name="user_limit" id="user_limit" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('package_manage.storage_limit') }}</label>
                                <input type="number" class="form-control " name="storage_limit" id="storage_limit" />
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <blockquote class="quote-primary text-md" style="margin: 0 !important;">
                                {{ __('package_manage.feature_lists') }}
                            </blockquote>
                        </div>

                        @foreach ($feature_titles as $key_title => $title)
                            <div class="col-sm-12 text-md text-bold mb-3 mt-3">
                                {{ $key_title + 1 . '. ' . $title->name_th }}
                            </div>
                            @foreach ($feature_lists as $key => $list)
                                @if ($list->feature_title_id == $title->id)
                                    <div class="col-sm-6">
                                        <div class="icheck-primary">
                                            <input name="feature_lists" type="checkbox"
                                                id="chkboxListId{{ $key }}" value="{{ $list->id }}" />
                                            <label for="chkboxListId{{ $key }}">{{ $list->name_th }}</label>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
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
