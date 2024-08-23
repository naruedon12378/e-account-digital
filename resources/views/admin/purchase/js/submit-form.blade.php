<script>
    $(document).on('click', '#frmPurchase #btnSubmit', function () {
        let formData = new FormData($('#frmPurchase')[0]);
        let routeName = $('#frmPurchase').attr('action');
        formData.append('items', JSON.stringify(state.items));
        formData.append('summary', JSON.stringify(state.summary));
        $.ajax({
            type: "POST",
            url: routeName,
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (data) {
                window.location.href = data;
            },
            error: function (message) {
                $('.invalid').html('');
                for (const key in message.responseJSON.errors) {
                    if (key.includes('.')) {
                        let val = key.replace(key.slice(-2), '');
                        $('.invalid.' + val).html(message.responseJSON, errors[key]);
                    } else {
                        $('.invalid.' + key).html(message.responseJSON.errors[key]);
                    }
                }
            }
        });
    });
</script>
