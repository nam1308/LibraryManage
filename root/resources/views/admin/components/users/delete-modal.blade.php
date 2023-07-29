<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title font-weight-normal" id="exampleModalLabel">Bạn có muốn xoá người dùng này?</h6>
              <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
              </button>
          </div>
          <form id="delete-form" action="{{ route('users.delete') }}" method="post">
              <div class="modal-body">
                  @csrf
                  <input id="id-delete-input" type="hidden" class="form-control" id="id" name="id" />
                  <input id="email-delete-input" type="hidden" class="form-control" id="email" name="email" />
                  <div id="reason-group" class="input-group input-group-static mb-4">
                      <label class="" for="reason-input">
                          Lý do
                          <span class="text-danger">*</span>
                      </label>
                      <textarea id="reason-input" autocomplete="off" class="form-control" name="reason"  rows="3"></textarea>
                      <span id="reason-error"></span>
                  </div>
              </div>
              <div class="modal-footer d-flex justify-content-center">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                  <button type="submit" class="btn bg-gradient-danger">Đồng ý</button>
              </div>
          </form>
      </div>
  </div>
</div>