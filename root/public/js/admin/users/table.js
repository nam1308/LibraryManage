function fmDate(date){
    var currentDate = new Date(date);
    var year = currentDate.getFullYear();
    var month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
    var day = (currentDate.getDate() + 1).toString().padStart(2, '0');
    return day + '-' + month + '-' + year;
}

async function getData(id) {
    const baseUrl = window.location.origin;
    await $.ajax({
        url: '/admin/users/' + id,
        type: 'GET',
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success:  function (response) {
            $.each(response, function (key, value) {
                $('#modal-open-edit #' + key).val(value);
            });
            $('#modal-open-edit #birthday').val(fmDate(response.birthday));
            formatDate($('#modal-open-edit #birthday'), fmDate(response.birthday), new Date(), null);
            var linkimage = baseUrl + '/storage/' + response.avatar;
            if(response.avatar)
            {
                $('#modal-open-edit #avatar_old').val(response.avatar);
                $('#modal-open-edit .uploadFile,#modal-open-edit .wrapper').addClass('active');
                $('#modal-open-edit #imgEditModal').attr('src', linkimage);
            }
            $('#modal-open-edit').modal('show');
        },
        error: function (xhr) {
            showMessageToast({status: 0, message: "Đã xảy ra lỗi!"}, "bg-gradient-warning");
        }
    });
};
