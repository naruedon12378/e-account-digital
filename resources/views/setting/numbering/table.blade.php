<x-collapse number="{{ $setting['transaction_type'] }}" title="{{ __('doc_setting.' . $setting['transaction_type']) }} | <span class='number'>{{ $setting['next_number'] }}</span>" show>
    <x-form name="{{ $setting['transaction_type'] }}" :action="route('numbering_system.store')">
        @csrf
        <input type="hidden" name="id" value="{{ $setting['id'] }}">
        <input type="hidden" name="transaction_type" value="{{ $setting['transaction_type'] }}">

        <div class="table-responsive border-top">
            <table id="itemTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th width="14%">Prefix
                            <small class="text-secondary">(4)</small>
                        </th>
                        <th width="10%">Symbol
                            <small class="text-secondary">(1)</small>
                        </th>
                        <th width="38%">Year</th>
                        <th width="8%">Month</th>
                        <th width="8%">Date</th>
                        <th width="12%">Digit of running</th>
                        <th class="text-center" width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-0">
                            <input type="text" name="prefix" class="form-control border-0" maxlength="4"
                                value="{{ $setting['prefix'] }}" />
                        </td>
                        <td class="p-0">
                            <input type="text" name="symbol" class="form-control border-0" maxlength="1"
                                value="{{ $setting['symbol'] }}" />
                        </td>
                        <td class="p-0">
                            <select name="year" class="form-control border-0">
                                <option value="1" @if ($setting['year'] == 1) selected @endif>
                                    Year 4 digit in Anno Domini calendar ({{ years()[1] }})
                                </option>
                                <option value="2" @if ($setting['year'] == 2) selected @endif>
                                    Year 4 digit in Buddhist calendar ({{ years()[2] }})
                                </option>
                                <option value="3" @if ($setting['year'] == 3) selected @endif>
                                    Year 2 digit in Anno Domini calendar ({{ years()[3] }})
                                </option>
                                <option value="4" @if ($setting['year'] == 4) selected @endif>
                                    Year 2 digit in Buddhist calendar ({{ years()[4] }})
                                </option>
                                <option value="0" @if ($setting['year'] == 0) selected @endif>
                                    Not Show
                                </option>
                            </select>
                        </td>
                        <td>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="month"
                                    id="month{{ $setting['transaction_type'] }}" value="1"
                                    @if ($setting['month']) checked @endif>
                                <label class="custom-control-label"
                                    for="month{{ $setting['transaction_type'] }}"></label>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="date"
                                    id="date{{ $setting['transaction_type'] }}" value="1"
                                    @if ($setting['date']) checked @endif>
                                <label class="custom-control-label"
                                    for="date{{ $setting['transaction_type'] }}"></label>
                            </div>
                        </td>
                        <td class="p-0">
                            <select name="digit" class="form-control border-0">
                                @for ($i = 2; $i < 10; $i++)
                                    <option value="{{ $i }}"
                                        @if ($setting['digit'] == $i) selected @endif>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-outline-primary btn-sm jsSubmit"
                                data-id="{{ $setting['transaction_type'] }}">
                                <i class="fa-solid fa-circle-check mr-2"></i>
                                Save
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </x-form>
</x-collapse>
