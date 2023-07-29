  <!-- Modal -->
  <div class="modal fade" id="returnBookModal" data-bs-backdrop="static" tabindex="-1"
      aria-labelledby="returnBookModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="returnBookModalLabel">{{ $book->name }}</h5>
                  <button type="button" class="btn-close bg-dark CloseModalBookReturn" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body text-center">
                  <form action="{{ route('book.return', $book) }}" method="POST" id="formBookReturn">
                      @csrf
                      <input type="hidden" value="{{ $book->image }}" name="bookImage">
                      <input type="hidden"
                          value="{{ auth()->user()->name . ' đã trả thành công cuốn sách ' . $book->name . "của tác giả " .  $book->author . "."}}"
                          name="contentNotify">
                      <span class="text-dark fs-5">
                          Bạn có muốn trả cuốn sách này không ?
                      </span>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary CloseModalBookReturn" data-bs-dismiss="modal">Hủy</button>
                  <button type="submit" class="btn btn-primary" id="submitModalBookReturn">Xác nhận</button>
                  </form>
              </div>
          </div>
      </div>
  </div>
  @push('js')
      <script>
          var canSubmit = true;
          $("#submitModalBookReturn").click(function(e) {
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
              var form = $('#formBookReturn')[0];
              var data = new FormData(form);

              $.ajax({
                  type: "POST",
                  url: "{{ route('book.return', $book) }}",
                  data: data,
                  contentType: false,
                  processData: false,
                  dataType: "json",
                  success: function(data) {
                      if(data && data['status'] == 2){
                        $(".CloseModalBookReturn").click();
                        showToastFail(data);
                        location.reload();
                      }else {
                        $(".CloseModalBookReturn").click();
                        showToastSuccess(data);
                        setTimeout(function() {
                            window.location.href = "{{ route('home') }}";
                        }, 2000);
                        setTimeout(function() {
                          canSubmit = true;
                        }, 3000);
                      }
                  },
              });
          });
      </script>
  @endpush
