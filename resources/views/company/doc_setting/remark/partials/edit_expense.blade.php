<div class="row">
    <div class="col-12">
        <div class="mt-3">
            @foreach ($expense_docs as $doc)
                <label class="form-label col-12">{{ $doc['doc_type_text'] }} | <small class="text-black-50 ml-2"
                        id="ex_{{ $doc['doc_type'] }}"></small></label>
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="input-group bg-custom rounded p-0">
                            <label for="header_{{ $doc['doc_type'] }}"
                                class="form-control-file text-center mt-1">{{ __('doc_setting.remark') }}</label>
                            <textarea class="form-control" name="remark_{{ $doc['doc_type'] }}" id="remark_{{ $doc['doc_type'] }}" cols="30"
                                rows="4">{{ $doc['remark'] }}</textarea>
                        </div>
                    </div>
                </div>

                <hr style="border: 1px solid rgba(180, 180, 180, 0.439);width:90%;">
            @endforeach
        </div>
    </div>
</div>
