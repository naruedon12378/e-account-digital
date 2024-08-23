<form id="form">
    <div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">แก้ไขข้อมูล</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="eid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <blockquote class="quote-primary text-md" style="margin: 0 !important;">
                                    ข้อมูลแพ็คเกจ
                                </blockquote>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">ชื่อแพ็คเกจ (ภาษาไทย)</label>
                                <input class="form-control " name="ename_th" id="ename_th" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">ชื่อแพ็คเกจ (ภาษาอังกฤษ)</label>
                                <input class="form-control " name="ename_en" id="ename_en" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">รายละเอียดย่อย (ภาษาไทย)</label>
                                <textarea class="form-control " name="edescription_th" id="edescription_th" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">รายละเอียดย่อย (ภาษาอังกฤษ)</label>
                                <textarea class="form-control " name="edescription_en" id="edescription_en" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">ราคา</label>
                                <input type="number" class="form-control " name="eprice" id="eprice" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">ส่วนลด (ราคาที่ลดแล้ว)</label>
                                <input type="number" class="form-control " name="ediscount" id="ediscount" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">จำนวนผู้ใช้งานในระบบ</label>
                                <input type="number" class="form-control " name="euser_limit" id="euser_limit" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">หน่วยความจำสูงสุด</label>
                                <input type="number" class="form-control " name="estorage_limit" id="estorage_limit" />
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <blockquote class="quote-primary text-md" style="margin: 0 !important;">
                                รายการฟีเจอร์
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
                                            <input name="efeature_lists" type="checkbox"
                                                id="echkboxListId{{ $key }}" value="{{ $list->id }}" />
                                            <label for="echkboxListId{{ $key }}">{{ $list->name_th }}</label>
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
