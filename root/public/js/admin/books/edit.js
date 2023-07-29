$(document).ready(function () {
    var source = $('.btn-edit-book').data('source');
    var detailInput = $('#isDetail').val();
    $(document).on('click', '.btn-edit-book', function () {
        var bookId = $(this).data('id');
        var url = '/admin/books/edit/' + bookId;
        var userId = $(this).data('user-id');

        if (userId) {
            url += '?userId=' + userId;
            $('.user-book-id').val(userId);
        }

        const baseUrl = window.location.origin;
        $.ajax({
            url: url,
            type: 'GET',
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                $('#name-input-edit').val(response.book.name);
                $('.id-input').val(response.book.id);
                $('#book_cd-input-edit').val(response.book.book_cd);
                $('#quantity-input-edit').val(response.book.quantity);
                $('#author-input-edit').val(response.book.author);
                $('#user_id-input-edit').val(response.book.users?.[0]?.id).trigger('change');
                const cateArr = response.book.categories.map(cate => cate.id);
                $('#category-input-edit').val(cateArr).trigger('change');
                $('#description-input-edit').text(response.book.description);
                if (response.book.image) {
                    var linkimage = baseUrl + '/storage/' + response.book.image;
                    $('#edit-book #avatar_old').val(response.book.image);
                    $('.uploadFile>.wrapper, .uploadFile').addClass('active');
                    $(' #imgEditModal').attr('src', linkimage);
                }
                if (source === 'detail') {
                    $('.modal-title').text('Thêm sách');
                    $('#user_id-input-edit').val(null).trigger('change');
                    $('#quantity-input-edit').val(null);
                    $('#name-input-edit').prop('disabled', true);
                    $('#book_cd-input-edit').prop('disabled', true);
                    $('#author-input-edit').prop('disabled', true);
                    $('#category-input-edit').prop('disabled', true);
                    $('#description-input-edit').prop('disabled', true);
                    if (userId) {
                        $('.modal-title').text('Chỉnh sửa sách');
                        $('#quantity-input-edit').val(response.userBook.quantity);
                        $('#user_id-input-edit').val(response.userBook.user_id).trigger('change')
                    }
                } else {
                    $('.col-quantity-user').hide();
                }
            },
            error: function (xhr) {
                alert('đã xảy ra lỗi')
            }
        });
    });

    $('.modal#edit-book').on('shown.bs.modal', function () {
        $(this).find('.custom_select2_edit').select2({
            dropdownParent: $(this),
            width: "100%",
            selectionCssClass: ":all:",
            allowClear: true,
            tags: true,
            scrollAfterSelect: true
        });
        if($(this).find("#imgEditModal").attr('src')) {
            $(this).find('.uploadFile').addClass('active');
        }
    });

    function resetFormEdit() {
        $('#edit-name-error, #edit-book_cd-error, #edit-quantity-error, #edit-user_id-error, #edit-author-error, #edit-image-error, #edit-categories-error, #edit-description-error').empty();
    }

    $('#edit-book-form').submit(function (e) {
        e.preventDefault();
        $('#submitEditBook').prop('disabled', true);
        unDisable();
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
                if (!data.status) {
                    showMessageToast(data, "bg-gradient-warning");
                    disable()
                } else {
                    createSuccess(data)
                }
                $('#submitEditBook').prop('disabled', false);
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    resetFormEdit()
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function (field, messages) {
                        var fieldId = field.replace('.', '-');
                        var errorField = $('#' + 'edit-' + fieldId + '-error');
                        var errorMessages = '';

                        $.each(messages, function (index, message) {
                            if (index === 0) {
                                errorMessages += '<small>' + message + '</small><br>';
                            }
                        });

                        errorField.html(errorMessages);
                    });
                }
                if (detailInput) {
                    disable()
                }
                $('#submitEditBook').prop('disabled', false);
            }
        });
    });

    function createSuccess(data) {
        $('#edit-book').hide();
        showMessageToast(data, "bg-gradient-success");
        setTimeout(() => location.reload(), 2000);
    }

    $('.btn-close-edit,.btn-cancel-edit').on('click', function () {
        $('#edit-book-form')[0].reset();
        resetFormEdit();
        resetImage();
    });

    function unDisable() {
        $('#book_cd-input-edit, #name-input-edit, #author-input-edit, #category-input-edit, #description-input-edit').prop('disabled', false);
    }

    function disable() {
        $('#book_cd-input-edit, #name-input-edit, #author-input-edit, #category-input-edit, #description-input-edit').prop('disabled', true);
    }
})

