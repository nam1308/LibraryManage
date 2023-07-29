<div class="modal modal-borrow fade modal-lg" id="btnBorrow" data-bs-target="#btnBorrow" data-bs-backdrop='static'>
	<div class="modal-dialog">
		<div class="modal-content modal-content-borrow">
			@auth
			<div class="modal-header">
				<h5 class="modal-title" style="color: black;" id="exampleModalLabel">Mượn Sách</h5>
				<button type="button" class="btn btn-light btn-light-borrow rounded-pill" data-bs-dismiss="modal">
					<i class="fa-solid fa-xmark"></i>
				</button>
			</div>
			<div class="modal-body">
				<div id="borrowError" class="alert alert-danger" style="display: none;"></div>
				<div id="error-container" class="alert alert-danger d-none" role="alert">
					<span id="error-message"></span>
				</div>
				<form class="form-inline" id="formBorrowBook" method="POST" action="">
					@csrf
					<h3 class="text-center mb-4" style="color: #3366CC;" value="" name="book_name">{{$book->name}}</h3>				
					<input type="hidden" value="{{$book->id}}" name="book_id">			
					<input type="hidden" value="{{$book->name}}" name="book_name">			
					<input type="hidden" value="{{$book->author}}" name="author">
					<input type="hidden" value="{{$book->quantity}}" name="book_quantity">
					<input type="hidden" value="{{ auth()->user()->name . ' đã mượn thành công cuốn sách ' . $book->name . ' của tác giả ' . $book->author }}" name="contentNotify">
					<input type="hidden" value="{{$book->image}}" name="bookImage">
					<div class="row">
						<label for="" class="col-md-3 col-md-3-borrow col-form-label">Số lượng</label>
						<div class="col-md-8 col-sm-4">
							<input type="number" class="form-control form-control-borrow" id="quantityInput" name="quantity" min="1" max="1" step="1" value="1" readonly>
							<span id="quantityError" class="text-sm-start fs-6" style="color: red; display: none; margin-left: 10px;"></span>
						</div>
					</div> <br>
					<div class="row">
						<label for="" class="col-md-3 col-md-3-borrow col-form-label">Ngày trả</label>
						<?php $currentDate = date('Y-m-d'); ?>
						<div class="col-md-8 col-sm-4">
							<input type="text" class="form-control form-control-borrow" name="to_date" id="dateInput">
							<span id="dateError" class="text-sm-start fs-6" style="color: red; display: none; margin-left: 10px;"></span>
							<span id="dateError2" class="text-sm-start fs-6" style="color: red; display: none; margin-left: 5px;"></span>
						</div>
					</div>
					<br>
					<div class="row">
						<label for="" class="col-md-3 col-md-3-borrow col-form-label">Ghi chú</label>
						<div class="col-md-8 col-sm-4">
							<textarea type="text" class="form-control form-control-borrow" placeholder="Ghi chú" name="note"></textarea>
						</div>
					</div>
					<div class="form-check form-check-auto">
						<input class="form-check-input" type="checkbox" value="" name="auto_renew" id="fcustomCheck1">
						<label class="custom-control-label" style="color: black;" for="customCheck1">Tự động gia hạn 15 ngày</label>
					</div>
			<div class="modal-footer d-flex justify-content-center mt-2">
				<button type="submit" class="btn btn-primary rounded-pill">Mượn Sách</button>
			</div>
			</form>
			@else
			<div class="card">
                <div class="container">
                    <div class="row">
                        <div class="col-10 col-lg-11"></div>
                        <div class="col-2 col-lg-1">
                            <div class="modal_close text-center mt-2 p-1" style="width:40px; height: 40px; border-radius: 50%; background-color: #ccc;">
                                <a href="" class="" style="color: #fff;" data-bs-dismiss="modal">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="div_du text-center p-2">
                    <h4 class="card-title">Thông báo</h4>
                    <p class="card-text" style="color:black">Bạn phải đăng nhập mới có thể sử dụng tính năng này!</p>
                    <a href="{{route('login')}}" class="btn btn-primary">ĐĂNG NHẬP</a>
                </div>
            </div>
            @endauth
		</div>
	</div>
</div>
<!-- Style Modal -->
<link rel="stylesheet" href="{{asset('css/user/borrow/borrow_modal.css')}}">
@auth
<!-- Script process Input type Date -->
<script src="{{asset('js/user/borrow/input_modal_borrow.js')}}"></script>
@push('js')
<script>
	var today = moment();
	var toDate = today.add(30, 'days');
    var canSubmit = true;
    var submitCooldown = 2500;
	$("#dateInput").val(toDate.format("DD-MM-YYYY"));
	formatDate($("#dateInput"), toDate.format("DD-MM-YYYY"), null, new Date());
	$("#btnBorrow").submit(function(e) {
		e.preventDefault();
		if (!canSubmit) {
            return; // Chặn việc submit nếu đang trong thời gian chờ
        }
        canSubmit = false; // Đánh dấu đang submit
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var data = $('#formBorrowBook').serialize();
		$.ajax({
			type: "POST",
			url: "{{ route('book.details', $book) }}",
			data: data,
			dataType: "json",
			success: function(data) {
				if( data && data['status'] == 2 ){
					$('#btnBorrow').modal('hide');
					showToastFail(data);
					location.reload();
				}else {
					if (data['status'] == 200) {
						$('#btnBorrow').modal('hide');
						showToastSuccess(data);
						setTimeout(function() {
							window.location.replace("{{route('home')}}");
						}, 2500);
					} else {
						$('#btnBorrow').modal('hide');
						showToastFail(data);
						setTimeout(location.reload.bind(location), 1000);
					}
				}			
                setTimeout(function() {
                    canSubmit = true;
                }, submitCooldown);
			},
		});
	});
</script>
@endpush
@endauth