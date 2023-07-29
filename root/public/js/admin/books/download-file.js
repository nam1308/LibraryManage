$(document).ready(function () {
    $(document).on("click", "#downloadFile", function (e) {
        var fileName = $('#downloadFile').data('filename');
        $.ajax({
            url: '/admin/download/'+ fileName,
            type: 'GET',
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                if (response.status) {
                    showMessageToast(response, "bg-success");
                    var downloadLink = $('<a>')
                        .attr('href', '/admin/download/' + fileName)
                        .attr('download', fileName)
                        .css('display', 'none');
                    $('body').append(downloadLink);
                    downloadLink[0].click();
                    downloadLink.remove();
                } else {
                    showMessageToast(response, "bg-warning");
                }
            },
            error: function (xhr) {
                showMessageToast("Đã xảy ra lỗi", "bg-warning");
            },
        });
    });
});