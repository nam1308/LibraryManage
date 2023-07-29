  <div class="modal fade" id="bookRenewal" tabindex="-1" aria-labelledby="bookRenewal" aria-hidden="true" data-bs-backdrop='static'>
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Gia hạn sách</h4>
            <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" id="CloseModalRenewalBook" aria-label="Close"></button>
          </div>
          <div class="modal-body">
                      <form method="POST" id="renewalBookForm" action="{{ route('user.books.return', $book) }}">
                        @csrf
                        <div class="row m-2"> 
                            <h4 style="text-align: center;">{{ $book->name }}  -  {{$book->author }}</h4>
                        </div>
                        <input type="hidden" name="book_name"  class="form-control border p-2" value="{{  $book->name }}">
                        <input type="hidden" name="book_author"  class="form-control border p-2" value="{{  $book->author }}">
                        <input type="hidden" name="allowed_renewal" class="form-control border p-2" value="{{ $getBookFromBorrower->allowed_renewal }}" >
                        <input type="hidden" value="{{ auth()->user()->name." đã gia hạn thành công cuốn sách ".$book->name. " của tác giả " .$book->author }}" name="contentNotify">
                        <input type="hidden" name="bookId"  class="form-control border p-2" value="{{  $book->id }}">
                        <input type="hidden" name="bookImage"  class="form-control border p-2" value="{{  $book->image }}">
                        <div class="row m-2">
                            <div class="col-md-2"><label for="due_date" class="form-label">Thời gian</label></div>
                            @if($getBookFromBorrower->allowed_renewal == 0)
                                <div class="col-md-6"><input type="text" name="date" class="form-control border p-2" value="{{date_format( new DateTime($getBookFromBorrower->from_date),'d-m-Y')}}  ~  {{date_format( new DateTime($getBookFromBorrower->to_date),'d-m-Y')}}" readonly></div>
                            @else
                                <div class="col-md-6"><input type="text" name="date" class="form-control border p-2" value="{{date_format( new DateTime($getBookFromBorrower->from_date),'d-m-Y')}}  ~  {{date_format( new DateTime($getBookFromBorrower->extended_date),'d-m-Y')}}" readonly></div>
                            @endif
                        </div>
                        <div class="row m-2">
                            <div class="col-md-2"> <label class="labels">Số lượng</label></div>
                            <div class="col-md-6">
                                <input type="number" name="quantity" class="form-control border p-2" value="1" readonly>
                            </div>
                        </div>                        
                        <div class="row m-2">
                            <div class="col-md-2">
                                <label for="due_date" class="form-label">Ngày trả</label>
                            </div>
                            @if($getBookFromBorrower->allowed_renewal == 0)
                                <div class="col-md-6">
                                    <input type="text" class="form-control border p-2" id="due_date" name="due_date" value="{{ date('d-m-Y', strtotime($getBookFromBorrower->to_date . '+10 days')) }}">
                                </div>
                            @else
                                <div class="col-md-6">
                                    <input type="text" class="form-control border p-2" id="due_date" name="due_date" value="{{ date('d-m-Y', strtotime($getBookFromBorrower->extended_date . '+10 days')) }}">
                                </div>
                            @endif
                        </div>
                        <div class="row m-2">
                            <div class="col-md-2"><label for="note" class="form-label">Ghi chú</label></div>
                            <div class="col-md-9"><textarea class="form-control  border p-2" id="note" name="note"></textarea></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close" onclick="clearForm()">Đóng</button>
                            <button type="submit" class="btn btn-primary" id="submitRenewal">Gia hạn</button>
                        </div>
                    </form>
          </div>
      </div>
  </div>
  </div>
  @push('js')
    <script>
        var dueDate = $("#due_date").val();
        var fromDate = moment(dueDate, "DD-MM-YYYY");
        var toDate = moment(fromDate).add(5, 'days');
        var newMinDate = moment(fromDate).subtract(10, 'days');
        var canSubmit = true;
        var submitCooldown = 2500;
        formatDate($("#due_date"), dueDate, toDate.format("DD-MM-YYYY"), newMinDate.format("DD-MM-YYYY"));

        const CloseModalRenewalBook = document.getElementById('CloseModalRenewalBook');
        CloseModalRenewalBook.addEventListener('click', clearForm);

        $("#bookRenewal").submit(function(e){
            e.preventDefault();
            if (!canSubmit) {
                 return;
            }
            canSubmit = false;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var data = $('#renewalBookForm').serialize();

            $.ajax({
                type: "POST",
                url: "{{ route('user.books.return', $book) }}",
                data: data,
                dataType: "json",
                success: function(data) {
                    if(data && data['status'] == 2){
                        $('#bookRenewal').modal('hide');
                        showToastFail(data);
                        location.reload();
                    } else {
                        if(data['status'] == 200){
                            $('#bookRenewal').modal('hide');
                            showToastSuccess(data);
                            setTimeout(function() {
                                window.location.replace("{{route('home')}}");
                            }, 2000);
                        }
                        else{
                            showToastFail(data);
                            $('#bookRenewal').modal('hide');
                            setTimeout(location.reload.bind(location), 1000);
                        }
                    }
                    setTimeout(function() {
                        canSubmit = true;
                    }, submitCooldown);
                },
            });
        });

        $('#bookRenewal').on('hidden.bs.modal', function (e) {
            const myForm = document.getElementById('renewalBookForm');
            myForm.reset();
        })
        function clearForm() {
            const myForm = document.getElementById('renewalBookForm');
            myForm.reset();
        }
    </script>
  @endpush