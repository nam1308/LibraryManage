$(document).ready(function () {
    //ajax xóa thông báo tất cả
    $('.all-notifycation').on('click', function (e) {
        e.preventDefault();
        let href = $(this).attr('href');
        $.ajax({
            url: href,
            type: 'GET',
            success: function (data) {
                if (data.success) {
                    $('.count-notifycation').empty();
                    $('.form-notifycation-admin').remove();
                }
            },

        });
    });

    // ajax xóa 1 thông submit
    $('.form-notifycation-admin').on('submit', function (e) {
        e.preventDefault();
        var currentForm = this;
        var formData = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (data) {
                var newCountNotify = data.count;
                $('.count-notifycation').text(newCountNotify);
                currentForm.remove();
                if (newCountNotify < 1) {
                    $('.count-notifycation').empty();
                }
            },
            error: function (xhr, status, error) {
                alert('Chương trình đã xảy ra lỗi');
            }
        });
    });
});