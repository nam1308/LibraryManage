$(document).ready(function () {
    let debounceTimer;

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
                $('#table-borrower').html(data);
                scrollTopPaginate();
            },
            error: function (xhr, status, error) {
                alert("Đã xảy ra lỗi: " + error);
            }
        });
    }

    // lấy sự kiện người dùng click phần lọc category
    $(document).ready(function() {
        $('#category_id-input').on('change', function(e) {
            e.preventDefault();
            handleSearch($('#currentPage').val());
        });
    });

    // sự kiện tìm kiếm live-search
    $('#search-borrowers').on('keyup', function (e) {
        e.preventDefault();
        debounce(handleSearch($('#currentPage').val()), 1000);
    });

    // lấy sự kiện người dùng click phần lọc ngừoi dùng
    $('a.link-status-borrowers').on('click', function (e) {
        e.preventDefault();
        handleSearch($('#currentPage').val());
    });

    // hàm xử lý tìm kiếm
    function handleSearch(urlSearch) {
        let search = $('#search-borrowers').val();
        let categories = $('#category_id-input').find(':selected').data('categories');
        let status = $('a.link-status-borrowers.active').data('status');
        let data = {
            'searchAdmin': search,
            'categories': categories,
            'status' : status,
        };
        sendAjaxRequest(urlSearch, data);
    }

    // phân trang ajax
    $(document).on('click', '#paginator_user li a', function (e) {
        e.preventDefault();
        let urlPaginate = $(this).attr('href');
        handleSearch(urlPaginate);
    });

    $('#category_id-input').select2();
});
