<div class="row">
    <div class="col-12">
        <div class="mt-3">
            @foreach ($income_docs as $doc)
                <label class="form-label col-12">{{ $doc['doc_type_text'] }} | <small class="text-black-50 ml-2"
                        id="ex_{{ $doc['doc_type'] }}"></small></label>
                <div class="row">
                    <div class="col-2 mb-3">
                        <div class="input-group bg-custom rounded p-0">
                            <label for="header_{{ $doc['doc_type'] }}"
                                class="form-control-file text-center mt-1">{{ __('doc_setting.header') }}</label>
                            <input type="text" class="form-control rounded" id="header_{{ $doc['doc_type'] }}"
                                name="header_{{ $doc['doc_type'] }}" placeholder="" value="{{ $doc['header'] }}"
                                maxlength="4">
                        </div>
                    </div>

                    <div class="col-2 mb-3">
                        <div class="input-group bg-custom rounded p-0">
                            <label for="special_characters_{{ $doc['doc_type'] }}"
                                class="form-control-file text-center mt-1">{{ __('doc_setting.special_char') }}</label>
                            <input type="text" class="form-control rounded"
                                id="special_characters_{{ $doc['doc_type'] }}"
                                name="special_characters_{{ $doc['doc_type'] }}" placeholder=""
                                value="{{ $doc['special_characters'] }}" maxlength="1">
                        </div>
                    </div>

                    <div class="col-2 mb-3">
                        <div class="input-group bg-custom rounded p-0">
                            <label for="year_type_{{ $doc['doc_type'] }}"
                                class="form-control-file text-center mt-1">{{ __('doc_setting.year') }}</label>
                            <select name="year_type_{{ $doc['doc_type'] }}" id="year_type_{{ $doc['doc_type'] }}"
                                class="form-control rounded">
                                @for ($i = 1; $i <= 4; $i++)
                                    <option value="{{ $i }}"
                                        {{ $doc['year_type'] == $i ? 'selected' : '' }}>
                                        {{ $date['year_' . $i] }}</option>
                                @endfor
                                <option value="5" {{ $doc['year_type'] == 5 ? 'selected' : '' }}>
                                    {{ __('home.not_show') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-2 mb-3">
                        <div class="input-group bg-custom rounded p-0">
                            <label for="month_type_{{ $doc['doc_type'] }}"
                                class="form-control-file text-center mt-1">{{ __('doc_setting.month') }}</label>
                            <select name="month_type_{{ $doc['doc_type'] }}" id="month_type_{{ $doc['doc_type'] }}"
                                class="form-control rounded">
                                <option value="1" {{ $doc['month_type'] == 1 ? 'selected' : '' }}>
                                    {{ __('home.show') }}
                                </option>
                                <option value="2" {{ $doc['month_type'] == 2 ? 'selected' : '' }}>
                                    {{ __('home.not_show') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-2 mb-3">
                        <div class="input-group bg-custom rounded p-0">
                            <label for="date_type_{{ $doc['doc_type'] }}"
                                class="form-control-file text-center mt-1">{{ __('doc_setting.day') }}</label>
                            <select name="date_type_{{ $doc['doc_type'] }}" id="date_type_{{ $doc['doc_type'] }}"
                                class="form-control rounded">
                                <option value="1" {{ $doc['date_type'] == 1 ? 'selected' : '' }}>
                                    {{ __('home.show') }}</option>
                                <option value="2" {{ $doc['date_type'] == 2 ? 'selected' : '' }}>
                                    {{ __('home.not_show') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-2 mb-3">
                        <div class="input-group bg-custom rounded p-0">
                            <label for="length_number_doc_{{ $doc['doc_type'] }}"
                                class="form-control-file text-center mt-1">{{ __('doc_setting.length_doc_number') }}</label>
                            <select name="length_number_doc_{{ $doc['doc_type'] }}"
                                id="length_number_doc_{{ $doc['doc_type'] }}" class="form-control rounded">
                                @for ($i = 2; $i <= 9; $i++)
                                    <option value="{{ $i }}"
                                        {{ $doc['length_number_doc'] == $i ? 'selected' : '' }}>{{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <hr style="border: 1px solid rgba(180, 180, 180, 0.439);width:90%;">
            @endforeach
        </div>
    </div>
</div>
