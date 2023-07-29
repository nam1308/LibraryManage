$(document).ready(function () {
    let debounceTimer;
    const urlSearch = $('#route-data').data('url');

    function debounce(func, delay) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(func, delay);
    }

    function resetFormBlock() {
        $('#form-block-user')[0].reset();
        $('#reasonError').empty();
    }

    function sendAjaxRequest(url, data) {
        $.ajax({
            url: url,
            type: "GET",
            data: data,
            success: function (data) {
                $('#table-user').fadeOut(70, function () {
                    $('#table-user').html(data);
                    $('#table-user').fadeIn(70);
                });
            },
            error: function (xhr, status, error) {
                alert("Đã xảy ra lỗi: " + error);
            }
        });
    }

// lấy sự kiện người dùng click phần lọc ngừoi dùng
    $('a.link-status-user').on('click', function (e) {
        e.preventDefault();
        $('#search-user').val('');
        let status = $(this).data('status');
        const page = $('#currentPage').val();
        let data = {
            'status': status,
            'page' : page
        };
        sendAjaxRequest(urlSearch, data);
    });

// sự kiện tìm kiếm live-search
    $('#search-user').on('keyup', function (e) {
        e.preventDefault();
        debounce(function () {
            let search = $('#search-user').val();
            let status = $('.link-status-user.active').data('status');
            const page = $('#currentPage').val();
            let data = {
                'search': search,
                'status': status,
                'page':page
            };
            sendAjaxRequest(urlSearch, data);
        }, 1000);
    });

// phân trang ajax
    $(document).on('click', '#paginator_user li a', function (e) {
        e.preventDefault();
        let urlPaginate = $(this).attr('href');
        $.ajax({
            url: urlPaginate,
            type: "GET",
            data: {},
            success: function (data) {
                $('#table-user').fadeOut(70, function () {
                    $('#table-user').html(data);
                    $('#table-user').fadeIn(70);
                });
                scrollTopPaginate();
            },
            error: function (xhr, status, error) {
                alert("Đã xảy ra lỗi: " + error);
            }
        });
    });

// sự kiện khi người dùng  click gọi modal block user
    $(document).on('click', '#block-btn-user', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var email = $(this).data('email');
        $('#user-id-block').val(id);
        $('#email-block').val(email);
    });
    $(document).on('click', '.btn-close-block, .btn-cancel-block-modal', function (e) {
        resetFormBlock();
    });
// submit form ,nếu thành công hiển thị thông báo và sau 2 giây load lại trang
    $('#form-block-user').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var reasonError = form.find('#reasonError');
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: $('#form-block-user').serialize(),
            dataType: 'json',
            success: function (data) {
                $('#block-modal').modal('hide');
                form[0].reset();
                var toastContainer = $('.toast-container');
                var toast = $('#messageToast');
                var toastBody = toast.find('.toast-body');
                toast.removeClass('bg-gradient-success bg-gradient-warning text-white');
                if (data.status) {
                    showMessageToast(data, "bg-gradient-success");
                } else {
                    showMessageToast(data, "bg-gradient-warning");
                }
                setTimeout(function () {
                    location.reload();
                }, 2000);
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = errors && errors.reason ? errors.reason[0] : '';
                    reasonError.html('<small>' + errorMessage + '</small>');
                }
            }
        });
    });
    // sự kiện click mở khóa người dùng
    $(document).on('click', '#unBlock-btn-user', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var email = $(this).data('email');
        $('#user-id-unBlock').val(id);
        $('#email-unBlock').val(email);
    });
    // popup mở khoá người dùng
    $('#unblock-form').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var reasonError = form.find('#reason-error-unblock');
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (data) {
                $('#unblock-modal').modal('hide');
                form[0].reset();
                var toast = $('#messageToast');
                toast.removeClass('bg-gradient-success bg-gradient-warning text-white');
                if (data.status) {
                    showMessageToast(data, "bg-gradient-success");
                }
                setTimeout(function () {
                    location.reload();
                }, 2000);
            },
            error: function (xhr) {
                alert('Có lỗi xảy ra ,vui lòng thử lại');
            }
        });
    });


});
