<thead class="bg-custom">
    <tr>
        @foreach ($mycolumns as $column)
            <th class="text-center" style="width: {{ $column['width'] }} !important">{{ __($column['name']) }}</th>
        @endforeach
    </tr>
</thead>
