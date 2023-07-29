<div class="modal fade" id="block-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title font-weight-normal" id="exampleModalLabel">Bạn có muốn khóa người dùng này?</h6>
                <button type="button" class="btn-close btn-close-block text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-block-user" action="{{route('admin.users.block')}}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="input-group input-group input-group-static mb-4">
                        <label class="" for="reason-input">
                            Lý do
                            <span class="text-danger">*</span>
                        </label>
                        <textarea name="reason" autocomplete="off" class="form-control" rows="3" id="reason-block">{{ old('reason') }}</textarea>
                        <span id="reasonError" class="text-danger"></span>
                    </div>
                </div>
                <input type="hidden" id="user-id-block" name="user_id">
                <input type="hidden" id="email-block" name="email">
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-secondary btn-cancel-block-modal" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" class="btn bg-gradient-danger">Đồng ý</button>
                </div>
            </form>
        </div>
    </div>
</div>

