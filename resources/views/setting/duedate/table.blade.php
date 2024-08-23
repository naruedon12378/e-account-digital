<x-collapse number="{{ $setting['transaction_type'] }}" title="{{ __('doc_setting.' . $setting['transaction_type']) }}" show>
    <input type="hidden" name="id[]" value="{{ $setting['id'] }}">
    <input type="hidden" name="transaction_type[]" value="{{ $setting['transaction_type'] }}">
    <div class="table-responsive border-top">
        <table id="itemTable" class="table table-bordered">
            <thead>
                <tr>
                    <th width="40%">Due Date Type</th>
                    <th width="20%">Period</th>
                    <th width="20%">Issue Date</th>
                    <th width="20%">Due Date</th>
                </tr>
            </thead>
            <tbody>
                <tr data-id="{{ $setting['transaction_type'] }}">
                    <td class="p-0">
                        <select name="format[]" class="form-control border-0">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </td>
                    <td class="p-0">
                        <input type="number" name="period[]" class="form-control border-0"
                            value="{{ $setting['period'] }}" min="0" />
                    </td>
                    <td>{{ $setting['issue_date'] }}</td>
                    <td id="due_date{{ $setting['transaction_type'] }}">{{ $setting['due_date'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</x-collapse>