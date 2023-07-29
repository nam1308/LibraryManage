<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="create-modal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="create-modal">Thêm người dùng</h1>
				<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" action="{{ route('users.store') }}" method="POST" id="create-form" enctype="multipart/form-data" novalidate>
				@csrf
				<div class="modal-body">
					<div class="row">
						<div class="col-12 col-lg-3">
							<div id="avatar-group" class=" mb-4">
								<label class="fw-bold" id="avatar-label" for="avatar-input">
									Ảnh đại diện
									<span class="text-danger">*</span>
								</label>
								@include('admin.components.users.uploadImage-modal')
								<span id="avatar-error"></span>
							</div>
						</div>
						<div class="col-12 col-lg-9">
							<div class="row">
								<div class="col-12 col-lg-6">
									<div id="name-group" class=" mb-4">
										<label class="fw-bold" id="name-label" for="name-input">
											Họ tên
											<span class="text-danger">*</span>
										</label>
										<input id="name-input" autocomplete="off" type="text" class="form-control border border-black px-2" name="name" placeholder="Tên" >
										<span id="name-error"></span>
									</div>
								</div>
								<div class="col-12 col-lg-6">
									<div id="employee_id-group" class=" mb-4">
										<label class="fw-bold" id="employee_id-label" for="employee_id-input">
											Mã người dùng
											<span class="text-danger">*</span>
										</label>
										<input id="employee_id-input" autocomplete="off" type="text" class="form-control border border-black px-2" name="employee_id" placeholder="Mã người dùng" >
										<span id="employee_id-error"></span>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-12 col-lg-6">
									<div id="email-group" class=" mb-4">
										<label class="fw-bold" id="email-label" for="email-input">
											Email
											<span class="text-danger">*</span>
										</label>
										<input id="email-input" autocomplete="off" type="email" class="form-control border border-black px-2" name="email" placeholder="Email" >
										<span id="email-error"></span>
									</div>
								</div>
								<div class="col-12 col-lg-6">
									<div id="gender-group" class=" mb-4">
										<label class="fw-bold" id="gender-label" for="gender-input">
											Giới tính
											<span class="text-danger">*</span>
										</label>
										<select id="gender-input" class="form-control form-select border border-black px-2" name="gender">
											@foreach(App\Enums\UserEnums::GENDER as $key=>$value)
												<option value="{{ $key }}">{{ $value }}</option>
											@endforeach
										</select>
										<span id="gender-error"></span>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-12 col-lg-6">
									<div id="birthday-group" class=" mb-4">
										<label class="fw-bold" id="birthday-label" for="birthday-input">
											Ngày sinh
											<span class="text-danger">*</span>
										</label>
										<input id="birthday-input" type="text" class="form-control border border-black px-2" name="birthday"/>
										<span id="birthday-error"></span>
									</div>
								</div>
								<div class="col-12 col-lg-6">
									<div id="department_id-group" class=" mb-4">
										<label class="fw-bold" for="department_id-input">
											Phòng ban
											<span class="text-danger">*</span>
										</label>
										<select id="department_id-input" class="form-control form-select border border-black px-2" name="department_id">
											@foreach(App\Enums\UserEnums::DEPARTMENT as $key=>$value)
												<option value="{{ $key }}">{{ $value }}</option>
											@endforeach
										</select>
										<span id="department_id-error"></span>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col">
									<div id="address-group" class=" mb-4">
										<label class="fw-bold" for="address-input">Quê quán</label>
										<input id="address-input" autocomplete="off" type="text" class="form-control border border-black px-2" name="address" placeholder="Quê quán"/>
										<span id="address-error"></span>
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
					</div>

				</div>
				<div class="modal-footer d-flex justify-content-center">
					<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Hủy</button>
					<button type="submit" id="create_user" class="btn bg-gradient-danger">Lưu</button>
				</div>
			</form>
		</div>
	</div>
</div>