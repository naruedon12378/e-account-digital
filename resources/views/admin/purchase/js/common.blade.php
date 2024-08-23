
<script src="{{ asset('js/admin/chargeitem.js') }}"></script>
<script>
    var alertMessage = "{{ trans('file.Quantity exceeds stock quantity') }}";
    var productList = @json(productList());
    var items = @json(isset($items) ? $items : []);
    if (items.length > 0) {
        items.forEach(product => {
            rowItemTable(product);
        });
    }
</script>