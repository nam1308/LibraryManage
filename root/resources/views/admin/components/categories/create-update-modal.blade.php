<div class="modal fade" id="create-update-modal" tabindex="-1" aria-labelledby="createUpdate-modal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" ></h1>
				<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action="" id="createUpdate-form">
				@csrf
				<div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div id="category_cd-group" class=" mb-4">
                                <label class="fw-bold" id="category_cd-label" for="category_cd-input">
                                    Mã thể loại
                                    <span class="text-danger">*</span>
                                </label>
                                <input id="category_cd-input" autocomplete="off" type="text" class="form-control border border-black px-2" name="category_cd" placeholder="Mã thể loại" >
                                <span id="category_cd-error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div id="name-group" class=" mb-4">
                                <label class="fw-bold" id="name-label" for="name-input">
                                    Tên thể loại
                                    <span class="text-danger">*</span>
                                </label>
                                <input id="name-input" autocomplete="off" type="text" class="form-control border border-black px-2" name="name" placeholder="Tên thể loại" >
                                <span id="name-error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div id="status-group" class=" mb-4">
                                <label class="fw-bold" id="status-label" for="status-input">
                                    Trạng thái
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="status" id="status-input" class="form-control border border-black px-2">
                                    @foreach(App\Enums\CategoryEnums::STATUS as $key=>$value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <span id="status-error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div id="note-group" class=" mb-4">
                                <label class="fw-bold" for="note-input">Ghi chú</label>
                                <textarea id="note-input" autocomplete="off" class="form-control border border-black px-2" name="note" rows="3" placeholder="Ghi chú"></textarea>
                                <span id="note-error"></span>
                            </div>
                        </div>
                    </div>

				</div>
				<div class="modal-footer d-flex justify-content-center">
					<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Hủy</button>
					<button type="submit" class="btn bg-gradient-danger">Lưu</button>
				</div>
			</form>
		</div>
	</div>
</div>