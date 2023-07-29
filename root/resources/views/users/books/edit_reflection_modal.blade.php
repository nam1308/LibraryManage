<div class="modal fade" id="editReflectionModal" tabindex="-1" aria-labelledby="editReflectionModal" data-bs-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bình luận</h5>
            </div>
            <div class="modal-body" style="padding: 0 20px 20px 20px;">
                <form method="POST" id="editReflectionForm">
                    @csrf
                    <header></header>
                    <div class="row m-2">
                        <div class="d-flex flex-column align-items-left col-lg-2">
                            <img class="w-100" id="preImg" src="{{ asset('storage/' . $book->image) }}">
                        </div>
                        <div class="col-md-9">
                            <div class="col-md-5"><label class="form-label fw-bold" name="book_name"
                                    style="font-size: 16px">{{ $book->name }}</label></div>
                            <div class="fs-6 md-3">Thể loại:
                                <span class="text-success">
                                    @if (count($book->categories) > 3)
                                        @for ($i = 0; $i < 3; $i++)
                                            {{ $book->categories[$i]['name'] . ', ' }}
                                        @endfor
                                        ...
                                    @else
                                        @foreach ($book->categories as $bookCate)
                                            {{ $bookCate->name }},
                                        @endforeach
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="book_name" class="form-control border p-2" value="{{ $book->name }}">
                    <input type="hidden" name="book_id" class="form-control border p-2" value="{{ $book->id }}">
                    <div class="row m-2" style="padding: 10px 0px">
                        <div class="col-md-3"> <label class="labels fw-bold" style="font-size: 16px">Mức độ yêu
                                thích:</label></div>
                            <div class="col-md-3 star-widget" style="padding: 0px" name="vote" id="update-vote-input">
                                <input type="radio" name="rate" value="5" id="edit-rate-5">
                                <label for="edit-rate-5" class="fas fa-star" style="cursor: pointer"></label>
                                <input type="radio" name="rate" value="4" id="edit-rate-4">
                                <label for="edit-rate-4" class="fas fa-star" style="cursor: pointer"></label>
                                <input type="radio" name="rate" value="3" id="edit-rate-3">
                                <label for="edit-rate-3" class="fas fa-star" style="cursor: pointer"></label>
                                <input type="radio" name="rate" value="2" id="edit-rate-2">
                                <label for="edit-rate-2" class="fas fa-star" style="cursor: pointer"></label>
                                <input type="radio" name="rate" value="1" id="edit-rate-1">
                                <label for="edit-rate-1" class="fas fa-star" style="cursor: pointer"></label>
                                <span style="padding-left: 33px" id="update-rate-error"></span>
                            </div>
                    </div>
                    <div class="row m-2">
                        <div class="col">
                            <textarea class="form-control  border p-2 fs-6" id="content-input" name="note"
                                placeholder="Hãy chia sẻ những điều mà bạn cảm thấy hay nhất về cuốn sách này." style="height: 150px"></textarea>
                            <span id="update-note-error"></span>
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="check" id="is_hidden-input" value="1"
                            checked>
                        <label class="form-check-label mb-0 ms-3" for="is_hidden-input"
                            style="color: #8388a0; font-weight: bold; font-size: 16px">Hiển thị tên đăng nhập trên
                            phần phản hồi</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="clearFormReflection()">Quay lại</button>
                        <button type="submit" id="edit-reflection-btn" class="btn btn-primary">Gửi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        function clearFormReflection() {
            const myForm = document.getElementById('editReflectionForm');
            myForm.reset();
            $("span.error").remove();
        }

        async function getData(id) {
            await $.ajax({
                url: '/book/reflection/edit/' + id,
                type: 'GET',
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: (data) => {
                    $('#editReflectionModal form #content-input').val(data.content);
                    if (data.is_hidden == '{{ config('constants.USER_NAME_HIDDEN_TRUE') }}') {
                        $('#editReflectionModal form #is_hidden-input').prop('checked', true);
                    } else {
                        $('#editReflectionModal form #is_hidden-input').prop('checked', false);
                    }
                    $('#editReflectionModal').modal('show');
                    $('#editReflectionModal form #edit-rate-' + data.vote).click();
                },
                error: (data) => {
                    showToastFail(data);
                }
            });
        };
        var canSubmit = true;
        var submitCooldown = 2500;
    $(document).off("click", "#edit-reflection-btn").on("click", "#edit-reflection-btn", function(e) {
        e.preventDefault();
        if (!canSubmit) {
            return; 
        }
        canSubmit = false; 
        setTimeout(function() {
            canSubmit = true;
        }, submitCooldown);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const reflectionId = $('#btnEditReflection').data('id');
        var url = $('#btnEditReflection').data('action-update');
        var data = $('#editReflectionForm').serialize();
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: "json",
            success: function(response) {
                if(response && response['status'] == 2){
                    location.reload();}
                // Xử lý kết quả trả về từ server
                else{
                    if (response.status == 'success') {
                    showToastSuccess({
                        title: 'Thông báo',
                        message: response.message
                    });
                    $('#editReflectionModal').modal('hide');
                    $('#editReflectionForm')[0].reset();
                    setTimeout(location.reload(), 2000);
                    scrollTopPaginate();
                    } else {
                        showToastFail({
                            title: 'Thông báo',
                            message: response.message
                        });
                        setTimeout(location.reload.bind(location), 2000);
                        scrollTopPaginate();
                    }
                } 
            },
            error: function(data) {
                var errors = data.responseJSON;
                showValidateError(errors.errors);    
            }
        });
    });

    function showValidateError(errors) {
        $("span.error").remove();
        for (var error in errors) {
            $("#update-" + error + "-error").append(
                '<span class="error text-danger"> <small>' +
                errors[error] +
                "</small></span>"
            );
        }
    }

    $('#update-vote-input, #content-input').on('input', function() {
            $('#update-' + $(this).attr('name') + '-error').empty();
    });

    $('#update-vote-input input').click(() => {
            $('#update-rate-error').empty();
    })

    </script>
@endpush