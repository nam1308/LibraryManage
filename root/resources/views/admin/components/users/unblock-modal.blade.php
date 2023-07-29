<div class="modal fade" id="unblock-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title font-weight-normal" id="exampleModalLabel">Bạn có muốn mở khóa người dùng này ?</h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="unblock-form" action="{{route('admin.users.unBlock')}}" method="post">
                @csrf
                <input type="hidden" id="email-unBlock" name="email">
                <input type="hidden" id="user-id-unBlock" name="user_id">
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-secondary btn-cancel-unblock-modal"
                            data-bs-dismiss="modal">Hủy bỏ
                    </button>
                    <button type="submit" class="btn bg-gradient-primary">Đồng ý</button>
                </div>
            </form>
        </div>
    </div>
</div>
