@include('components.index.datatable', [
    'columns' =>
        $status == 'all'
            ? ['Doc No.', 'Seller', 'Issue Date', 'Net Amount', 'Status']
            : ['Doc No.', 'Seller', 'Issue Date', 'Net Amount', 'Action'],
    'file' => 'purchase',
    'id' => 'table',
    'class' => '',
])
