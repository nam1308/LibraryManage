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
                $('#table-book').html(data);
                scrollTopPaginate();
            },
            error: function (xhr, status, error) {
                alert("Đã xảy ra lỗi: " + error);
            }
        });
    }

    // lấy sự kiện người dùng click phần lọc ngừoi dùng
    $(document).ready(function() {
        $('#category-list').on('change', function(e) {
            e.preventDefault();
            $('#search-book').val('');
            handleSearch($('#currentPage').val());
        });
    });

    // sự kiện tìm kiếm live-search
    $('#search-book').on('keyup', function (e) {
        e.preventDefault();
        debounce(handleSearch($('#currentPage').val()), 1000);
    });

    // hàm xử lý tìm kiếm
    function handleSearch(urlSearch) {
        let search = $('#search-book').val();
        let categories = $('#category-list').find(':selected').data('categories');
        let data = {
            'search': search,
            'categories': categories
        };
        sendAjaxRequest(urlSearch, data);
    }

    // phân trang ajax
    $(document).on('click', '#paginator_user li a', function (e) {
        e.preventDefault();
        let urlPaginate = $(this).attr('href');
        handleSearch(urlPaginate);
    });

    $('#category-list').select2();
});
