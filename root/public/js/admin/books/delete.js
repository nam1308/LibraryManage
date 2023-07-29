$(document).ready(function () {
    $(document).on("click", "#btn-delete", function (e) {
        $('#id-delete-input').val($(this).data('id'));
        $('#delete-form-book').attr('action', '/admin/books/delete/' + $(this).data('id'));
    });
    $('#delete-form-book').submit(function (event) {
        event.preventDefault();
        var form = this;
        $.ajax({
            url: $(form).prop("action"),
            type: 'DELETE',
            processData: false,
            dataType: "json",
            contentType: false,
            data: new FormData(form),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status) {
                    showMessageToast(response, "bg-success");
                    setTimeout(()=> location.reload(), 2000);
                } else {
                    showMessageToast(response, "bg-warning");
                }
            },
            error: function (err) {
                showMessageToast('Lỗi', "bg-warning");
            }
        });
    });
});
