<table id="{{ $id }}" class="table table-hover {{ $class }}">
    <thead>
        <tr>
            <th class="not-exported"></th>
            @foreach ($columns as $key => $value)
                <th>{{ __($file.'.'.$value) }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
