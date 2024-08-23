<div class="table-responsive">
    <table id="{{ $id }}" class="table table-hover {{ $class }}" style="width:100%;">
        <thead>
            <tr>
                <th class="not-exported"></th>
                @foreach ($columns as $key => $value)
                    @if ($key == 'Action')
                    <th class="not-exported">{{ __($file.'.'.$value) }}</th>
                    @else
                    <th>{{ __($file.'.'.$value) }}</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>