<div class="modal fade" id="delete-giver-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title font-weight-bold" id="exampleModalLabel">Xác nhận</h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form id="delete-giver-form" method="POST">
                @csrf
                <div class="modal-body">
                    <input id="id-delete-giver-input" type="hidden" class="form-control" name="id" />
                    <p class="text-center" style="color: #000;">Bạn có muốn xóa người tặng này không ?</p>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Không</button>
                    <button type="submit" class="btn bg-gradient-danger">Có</button>
                </div>
            </form>
        </div>
    </div>
</div>