<div class="row">
    <div class="col-12">
        <div class="mt-3">
            @foreach ($income_docs as $doc)
                <label class="form-label col-12">{{ $doc['doc_type_text'] }} | <small class="text-black-50 ml-2"
                        id="ex_{{ $doc['doc_type'] }}"></small></label>
                <div class="row">
                    <div class="col-4 mb-3">
                        <div class="input-group bg-custom rounded p-0">
                            <label for="header_{{ $doc['doc_type'] }}"
                                class="form-control-file text-center mt-1">{{ __('doc_setting.due_date_type') }}</label>
                            <select class="form-control format-element" data-type="{{ $doc['doc_type'] }}"
                                name="format_due_date_{{ $doc['doc_type'] }}"
                                id="format_due_date_{{ $doc['doc_type'] }}">
                                <option value="1" {{ $doc['format_due_date'] == 1 ? 'selected' : '' }}>
                                    {{ __('doc_setting.due_option1') }}</option>
                                <option value="2" {{ $doc['format_due_date'] == 2 ? 'selected' : '' }}>
                                    {{ __('doc_setting.due_option2') }}</option>
                                <option value="3" {{ $doc['format_due_date'] == 3 ? 'selected' : '' }}>
                                    {{ __('doc_setting.due_option3') }}</option>
                                <option value="4" {{ $doc['format_due_date'] == 4 ? 'selected' : '' }}>
                                    {{ __('doc_setting.due_option4') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2 mb-3">
                        <div class="input-group bg-custom rounded p-0">
                            <label for="header_{{ $doc['doc_type'] }}"
                                class="form-control-file text-center mt-1">{{ __('doc_setting.due_day') }}</label>
                            <input type="number" name="length_due_date_{{ $doc['doc_type'] }}"
                                id="length_due_date_{{ $doc['doc_type'] }}" class="form-control" max="365"v
                                value="{{ $doc['length_due_date'] }}"
                                {{ $doc['format_due_date'] == 3 || $doc['format_due_date'] == 4 ? 'disabled' : '' }}>
                        </div>
                    </div>
                    <div class="col-3 mb-3">
                        <div class="input-group bg-custom rounded p-0">
                            <label for="header_{{ $doc['doc_type'] }}"
                                class="form-control-file text-center mt-1">{{ __('doc_setting.due_issued_date') }}</label>
                            <input class="form-control" type="text" id="ex_issued_date_{{ $doc['doc_type'] }}"
                                value="{{ $doc['issued_date'] }}" disabled>
                        </div>
                    </div>
                    <div class="col-3 mb-3">
                        <div class="input-group bg-custom rounded p-0">
                            <label for="header_{{ $doc['doc_type'] }}"
                                class="form-control-file text-center mt-1">{{ __('doc_setting.due_date') }}</label>
                            <input class="form-control" type="text" id="ex_due_date_{{ $doc['doc_type'] }}"
                                value="{{ $doc['due_date'] }}" disabled>
                        </div>
                    </div>
                </div>
                <hr style="border: 1px solid rgba(180, 180, 180, 0.439);width:90%;">
            @endforeach
        </div>
    </div>
</div>
