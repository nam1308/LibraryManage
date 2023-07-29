<div class="modal fade" id="modal-form-import-file" tabindex="-1" role="dialog" aria-labelledby="modal-form-import-file" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title font-weight-bold" id="exampleModalLabel">Nhập file</h6>
                <button type="button" class="btn-close close-uploadFile text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form id="import-form-book" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="drag-area position-relative">
                        <div class="drag-area-content">
                            <div class="icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <p class="text-center text-content">Kéo và thả hoặc click để chọn tệp</p>
                            <input type="file" id="importFileUpload" name="fileCsv" hidden>
                        </div>
                        <div class="file-info">
                            <i class="fas fa-file-csv"></i>
                            <span></span>
                            <div class="btn-delete">x</div>
                        </div>
                    </div>
                    <p class="text-danger mb-0 mt-3" id="fileCsv_err" role="alert"></p>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn bg-gradient-danger d-flex justify-content-between align-items-center">
                        <div style="margin-right: 15px;">
                            <i class="fa-solid fa-file-import"></i>
                        </div>
                        Tải lên
                    </button>
                    <div class="btn btn-light downloadFile" id="downloadFile" data-filename="FileBook.csv">
                        Tải file mẫu
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script src="{{asset('js/admin/books/download-file.js')}}"></script>
@endpush