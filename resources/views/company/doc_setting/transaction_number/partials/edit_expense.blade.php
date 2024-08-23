<div class="row">
    <div class="col-12">
        <div class="mt-3">
            @foreach ($expense_docs as $doc)
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
                                <option value="1" {{ $doc['year_type'] == 1 ? 'selected' : '' }}>
                                    {{ $date['year_1'] }}</option>
                                <option value="2" {{ $doc['year_type'] == 2 ? 'selected' : '' }}>
                                    {{ $date['year_2'] }}</option>
                                <option value="3" {{ $doc['year_type'] == 3 ? 'selected' : '' }}>
                                    {{ $date['year_3'] }}</option>
                                <option value="4" {{ $doc['year_type'] == 4 ? 'selected' : '' }}>
                                    {{ $date['year_4'] }}</option>
                                <option value="5" {{ $doc['year_type'] == 5 ? 'selected' : '' }}>
                                    {{ __('home.not_show') }}</option>
                            </select>
                            {{-- <input type="text" class="form-control rounded" id="year_type_{{ $doc['doc_type'] }}"
                        name="year_type_{{ $doc['doc_type'] }}" placeholder=""> --}}
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
                            {{-- <input type="text" class="form-control rounded" id="month_type_{{ $doc['doc_type'] }}"
                        name="month_type_{{ $doc['doc_type'] }}" placeholder=""> --}}
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
                            {{-- <input type="text" class="form-control rounded" id="date_type_{{ $doc['doc_type'] }}"
                        name="date_type_{{ $doc['doc_type'] }}" placeholder=""> --}}
                        </div>
                    </div>

                    <div class="col-2 mb-3">
                        <div class="input-group bg-custom rounded p-0">
                            <label for="length_number_doc_{{ $doc['doc_type'] }}"
                                class="form-control-file text-center mt-1">{{ __('doc_setting.length_doc_number') }}</label>
                            <select name="length_number_doc_{{ $doc['doc_type'] }}"
                                id="length_number_doc_{{ $doc['doc_type'] }}" class="form-control rounded">
                                <option value="2" {{ $doc['length_number_doc'] == 2 ? 'selected' : '' }}>2
                                </option>
                                <option value="3" {{ $doc['length_number_doc'] == 3 ? 'selected' : '' }}>3
                                </option>
                                <option value="4" {{ $doc['length_number_doc'] == 4 ? 'selected' : '' }}>4
                                </option>
                                <option value="5" {{ $doc['length_number_doc'] == 5 ? 'selected' : '' }}>5
                                </option>
                                <option value="6" {{ $doc['length_number_doc'] == 6 ? 'selected' : '' }}>6
                                </option>
                                <option value="7" {{ $doc['length_number_doc'] == 7 ? 'selected' : '' }}>7
                                </option>
                                <option value="8" {{ $doc['length_number_doc'] == 8 ? 'selected' : '' }}>8
                                </option>
                                <option value="9" {{ $doc['length_number_doc'] == 9 ? 'selected' : '' }}>9
                                </option>
                            </select>
                            {{-- <input type="text" class="form-control rounded"
                        id="length_number_doc_{{ $doc['doc_type'] }}"
                        name="length_number_doc_{{ $doc['doc_type'] }}" placeholder=""> --}}
                        </div>
                    </div>
                </div>

                <hr style="border: 1px solid rgba(180, 180, 180, 0.439);width:90%;">
            @endforeach
        </div>
    </div>
</div>
