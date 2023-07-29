$(document).ready(function () {
    let debounceTimer;
    const urlSearch = $('#route-data').data('url');

    function debounce(func, delay) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(func, delay);
    }

    function sendAjaxRequest(url, data) {
        $.ajax({
            url: url,
            type: "GET",
            data: data,
            success: function (data) {
                $('#table').fadeOut(200, function () {
                    $('#table').html(data);
                    $('#table').fadeIn(200);
                });

                scrollTopPaginate();
            },
            error: function (xhr, status, error) {
                alert("Đã xảy ra lỗi: " + error);
            }
        });
    }

// lấy sự kiện người dùng click phần lọc ngừoi dùng
    $('a.link-status').on('click', function (e) {
        e.preventDefault();
        $('#search').val('');
        let status = $(this).data('status');
        let data = {
            'status': status
        };
        sendAjaxRequest(urlSearch, data);
    });

// sự kiện tìm kiếm live-search
    $('#search').on('keyup', function (e) {
        e.preventDefault();
        debounce(function () {
            let search = $('#search').val();
            let status = $('.link-status.active').data('status');
            let data = {
                'search': search,
                'status': status
            };
            sendAjaxRequest(urlSearch, data);
        }, 1000);
    });

// phân trang ajax
    $(document).on('click', '#paginator li a', function (e) {
        e.preventDefault();
        let urlPaginate = $(this).attr('href');
        $.ajax({
            url: urlPaginate,
            type: "GET",
            data: {},
            success: function (data) {
                $('#table').fadeOut(200, function () {
                    $('#table').html(data);
                    $('#table').fadeIn(200);
                });

                scrollTopPaginate();
            },
            error: function (xhr, status, error) {
                alert("Đã xảy ra lỗi: " + error);
            }
        });
    });
});
