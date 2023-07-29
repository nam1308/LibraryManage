$(document).ready(function () {

    var isSuccess = false;
    // sự kiện  chọn mã sách và tên sách
    $('#book_cd-input, #name-input').on('select2:select', function (e) {
        isNameSelected = true;
        isBookCdSelected = true;
        checkAndSendAjaxRequest();
    });

// modal create add select2
    $('.modal#create-book').on('shown.bs.modal', function () {
        $(this).find('.custom_select2').select2({
            dropdownParent: $(this),
            width: "100%",
            selectionCssClass: ":all:",
            allowClear: true,
            tags: true,
        });
        resetImage();
    });
// gửi form ajax tạo sách
    $('#create-book-form').submit(function (e) {
        e.preventDefault();

        if (!checkAndSendAjaxRequest()) {
            $('#author-input, #description-input, #category-input').prop('disabled', false);
        }

        var form = $(this);
        var formData = new FormData(form[0]);
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (data) {
                !data.status ? showMessageToast(data, "bg-gradient-warning") : createSuccess(data);
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    resetFormCreate();
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function (field, messages) {
                        var fieldId = field.replace('.', '-');
                        var errorField = $('#' + fieldId + '-error');
                        var errorMessages = '';

                        $.each(messages, function (index, message) {
                            if (index === 0) {
                                errorMessages += '<small>' + message + '</small><br>';
                            }
                        });

                        errorField.html(errorMessages);
                    });
                }
            }
        });
    });
    // đóng modal sẽ tự động reset dữ liệu của form
    $(document).on('click', '.btn-close-create, .btn-cancel-create', function () {
        $('#author-input, #description-input,#user_id-input, #category-input, #name-input, #book_cd-input').prop('disabled', false);
        $('#create-book-form')[0].reset();
        resetFormCreate();
        resetImage();
    });
    $(document).on('select2:unselect', '#name-input ,#book_cd-input', function (e) {
        resetOldFillData();
        isSuccess = false;
    });

    function resetFormCreate() {
        $('#name-error, #book_cd-error, #quantity-error, #user_id-error, #author-error, #image-error, #categories-error, #description-error').empty();
    }

    function createSuccess(data) {
        $('#create-book').hide();
        showMessageToast(data, "bg-gradient-success");
        setTimeout(() => location.reload(), 2000);
    }
    function resetOldFillData() {
        if (isSuccess === true) {
            $('#author-input').val('').prop('disabled', false);
            $('#description-input').val('').prop('disabled', false);
            $('#category-input').val(null).trigger('change').prop('disabled', false);
            resetFormCreate();
            resetImage();
        }
    }
    var isBookCdSelected = false;
    var isNameSelected = false;

    // fill dữ liệu nếu bị mã sách và tên sách có trong hệ thống
    function checkAndSendAjaxRequest() {
        if (isBookCdSelected && isNameSelected) {
            var bookCd = $('#book_cd-input').val();
            var bookName = $('#name-input').val();
            const baseUrl = window.location.origin;
            if (bookName && bookCd) {
                $.ajax({
                    url: '/admin/books/fetch-data',
                    type: 'GET',
                    data: {
                        name: bookName,
                        book_cd: bookCd
                    },
                    dataType: 'json',
                    success: function (data) {
                        resetFormCreate()
                        if (data.found === true) {
                            var book = data.book;
                            var categories = book.categories;
                            const cateArr = categories.map(cate => cate.id);
                            $('#author-input').val(book.author).prop('disabled', true);
                            $('#category-input').val(cateArr).trigger('change').prop('disabled', true);
                            $('#description-input').val(book.description).prop('disabled', true);
                            $('#avatar_old').val(book.image);
                            var linkimage = baseUrl + '/storage/' + book.image;
                            if (book.image) {
                                $('#create-book .uploadFile,.uploadFile>.wrapper').addClass('active');
                                $('#create-book #imgEditModal').attr('src', linkimage);
                                $('.uploadFile_content').addClass('d-none');
                            }
                            isSuccess = true;
                        } else {
                            resetOldFillData();
                            isSuccess = false;
                        }
                    },
                    error: function (xhr) {
                        resetFormCreate()
                        alert('chương trình gặp lỗi');
                    }
                });
            }
        }
    };
});
