<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title font-weight-normal" id="exampleModalLabel">
                    Bạn có muốn xoá thể loại
                    <span id="name-span" class="fw-bold"></span>
                </h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="delete-form" action="" method="post">
                @csrf
                <div class="modal-footer d-flex justify-content-center">
					<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Hủy bỏ</button>
                    <button type="submit" class="btn bg-gradient-danger">Đồng ý</button>
                </div>
            </form>
        </div>
    </div>
</div>