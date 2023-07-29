$(document).ready(function () {
    var initialValues = {};
    var imageChanged = false;

    $('#birthday').on('apply.daterangepicker', function() {
        checkFormChanges();
    });

    function saveInitialValues() {
        $('#name, #employee_id, #email, #gender, #birthday, #department_id, #address, #note').each(function () {
            var id = $(this).attr('id');
            var value = $(this).val();
            initialValues[id] = value;
        });
    }

    function checkFormChanges() {
        var hasChanges = false;
        $('#name, #employee_id, #email, #gender, #birthday, #department_id, #address, #note').each(function () {
            var id = $(this).attr('id');
            var initialValue = initialValues[id];
            var currentValue = $(this).val();
            if (initialValue !== currentValue) {
                hasChanges = true;
                return false;
            }
        });

        if (imageChanged || ($('#avatar_old').val() === '' && $('#updateUserForm input[name="avatar"]').get(0).files.length > 0)) {
            hasChanges = true;
        }
        $('#submitEdit').prop('disabled', !hasChanges);
    }

    const linkImage =  window.location.origin + '/storage/' + $("#avatar_old").val();

    $('#name, #email, #gender, #birthday, #department_id, #address, #note, #employee_id').on('input', function () {
        $('#' + $(this).attr('id') + '_err').text('');
        checkFormChanges();
    });

    $('#modal-open-edit').on('hidden.bs.modal', function () {
        $("#updateUserForm")[0].reset();
        $("#birthday").val($("#birthdayDetail").val());
        $("#imgEditModal").attr('src', linkImage);
        imageChanged = false;
        checkFormChanges();
        $(this).find("#avatar_err").text('');
        $('#name, #employee_id, #email, #gender, #birthday, #department_id, #address, #note').each(function () {
            $('#' + $(this).attr('id') + '_err').text('');
        });
    });

    $('#birthday').on('change', function() {
        $('#birthday_err').text('');
    });

    $("#modal-open-edit").on("show.bs.modal", function () {
        if($(this).find("#imgEditModal").attr('src')){
            $('#modal-open-edit .uploadFile,#modal-open-edit .wrapper').addClass('active');
        }
    });

    $('#updateUserForm input[name="avatar"]').on('change', function () {
        imageChanged = true;
        checkFormChanges();
    });

    $('#updateUserForm').submit(function (event) {
        event.preventDefault();
        $('#submitEdit').prop('disabled', true);
        const formData = new FormData($(this)[0]);
        if(!$('#updateUserForm input[name="avatar_old"]').val()){
            formData.set('avatar', '');
        }
        formData.append('_method', 'PUT');
        $.ajax({
            url: '/admin/users/show/'+ $("#id").val(),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                if (response.status) {
                    $('#modal-open-edit').modal('hide');
                    showMessageToast(response, "bg-success");
                    setTimeout(()=> location.reload(), 2000);
                } else {
                    showMessageToast(response, "bg-warning");
                }
                $('#submitEdit').prop('disabled', false);
            },
            error: function (xhr) {
                const errors = xhr.responseJSON.errors;
                for (var key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        $('#' + key + '_err').text(errors[key][0]);
                    }
                }
                $('#submitEdit').prop('disabled', false);
            },
        });
    });

    saveInitialValues();
    checkFormChanges();
});