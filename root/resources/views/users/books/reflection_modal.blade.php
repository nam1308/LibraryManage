<div class="modal fade" id="reflectionModal" tabindex="-1" aria-labelledby="reflectionModal" data-bs-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bình luận</h5>
            </div>
            <div class="modal-body" style="padding: 0 20px 20px 20px;">
                <form method="POST" id="reflectionForm" action="{{ route('user.books.reflection', $book) }}">
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
                    <input type="hidden" name="book_cd" class="form-control border p-2" value="{{ $book->id }}">
                    <div class="row m-2" style="padding: 10px 0px">
                        <div class="col-md-3"> <label class="labels fw-bold" style="font-size: 16px">Mức độ yêu
                                thích:</label></div>
                        <div class="col-md-3 star-widget" style="padding: 0px" name="vote" id="vote-input">
                            <input type="radio" name="rate" value="5" id="rate-5">
                            <label for="rate-5" class="fas fa-star" style="cursor: pointer"></label>
                            <input type="radio" name="rate" value="4" id="rate-4">
                            <label for="rate-4" class="fas fa-star" style="cursor: pointer"></label>
                            <input type="radio" name="rate" value="3" id="rate-3">
                            <label for="rate-3" class="fas fa-star" style="cursor: pointer"></label>
                            <input type="radio" name="rate" value="2" id="rate-2">
                            <label for="rate-2" class="fas fa-star" style="cursor: pointer"></label>
                            <input type="radio" name="rate" value="1" id="rate-1">
                            <label for="rate-1" class="fas fa-star" style="cursor: pointer"></label>
                            <span style="padding-left: 33px" id="rate-error"></span>
                        </div>
                    </div>
                    <div class="row m-2">
                        <div class="col">
                            <textarea class="form-control  border p-2 fs-6" id="note-input" name="note"
                                placeholder="Hãy chia sẻ những điều mà bạn cảm thấy hay nhất về cuốn sách này." style="height: 150px"></textarea>
                            <span id="note-error"></span>
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="check" id="check" value="1"
                            checked>
                        <label class="form-check-label mb-0 ms-3" for="check"
                            style="color: #8388a0; font-weight: bold; font-size: 16px">Hiển thị tên đăng nhập trên
                            phần phản hồi</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close"
                            onclick="clearForm()">Quay lại</button>
                        <button type="submit" id="reflection-btn" class="btn btn-primary">Gửi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        function clearForm() {
            const myForm = document.getElementById('reflectionForm');
            myForm.reset();
            $("span.error").remove();
        }
        var canSubmit = true;
        var submitCooldown = 2500;
        $(document).off("click", "#reflection-btn").on("click", "#reflection-btn", function(e) {
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
            var data = $('#reflectionForm').serialize();
            $.ajax({
                type: "POST",
                url: "{{ route('user.books.reflection', $book) }}",
                data: data,
                dataType: "json",
                success: function(response) {
                    // Xử lý kết quả trả về từ server
                    if(response && response['status'] == 2){
                        location.reload();
                    }else {
                        if (response.status == 'success') {
                            showToastSuccess({
                                title: 'Thông báo',
                                message: response.message
                            });
                            $('#reflectionModal').modal('hide');
                            $('#reflectionForm')[0].reset();
                            setTimeout(location.reload.bind(location), 2000);
                        } else {
                            showToastFail({
                                title: 'Thông báo',
                                message: response.message
                            });
                            setTimeout(location.reload.bind(location), 2000);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    var errors = xhr.responseJSON;
                    showValidateErrorMessage(errors.errors);
                }
            });
        });

        function showValidateErrorMessage(errors) {
            $("span.error").remove();
            for (var error in errors) {
                $("#" + error + "-error").append(
                    '<span class="error text-danger"> <small>' +
                    errors[error] +
                    "</small></span>"
                );
            }
        }
        $('#vote-input, #note-input').on('input', function() {
            $('#' + $(this).attr('name') + '-error').empty();
        });

        $('#vote-input input').click(() => {
            $('#rate-error').empty();
        })
    </script>
@endpush
<style>
    .edit:hover {
        text-decoration: underline;
    }

    .star-widget input {
        display: none;
    }

    .star-widget label {
        font-size: 24px;
        color: #898ea5;
        float: right;
        transition: all 0.2s ease;
    }

    input:not(:checked)~label:hover,
    input:not(:checked)~label:hover~label {
        color: #fd4;
    }

    input:checked~label {
        color: #fd4;
    }

    input#rate-5:checked~label {
        color: #fe7;
        text-shadow: 0 0 20px #952;
    }

    #rate-1:checked~form header:before {
        content: "I just hate it ";
    }

    #rate-2:checked~form header:before {
        content: "I don't like it ";
    }

    #rate-3:checked~form header:before {
        content: "It is awesome ";
    }

    #rate-4:checked~form header:before {
        content: "I just like it ";
    }

    #rate-5:checked~form header:before {
        content: "I just love it ";
    }

    input:checked~form {
        display: block;
    }
</style>
