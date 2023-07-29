@extends('users.layout.master')
@section('content')

@include('users.navbar.navbar', ['user' => "Trang cá nhân  ", 'urlUser' => route('user.show')])

<div class="row">
  <div class="col-12">
    <div class="card" style="padding: 1rem 1rem 2rem 1rem; margin-bottom: -1.25rem;">
      <div class="row">
        <div class="d-flex justify-content-end">
          <div class="p-2 col-lg-auto">
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#changeInfo">
              <i class="fa fa-edit" aria-hidden="true"></i>
            </button>
            {{-- Modal --}}
            @include('users.information.change_info_modal')
          </div>
          <div class="p-2 col-lg-auto">
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#changePassword">
              Đổi Mật Khẩu
            </button>
            {{-- Modal --}}
            @include('users.information.change_password_modal') 
          </div>
        </div>
      </div>

      <div class="col-md-12 d-flex justify-content-center">
        <label class="form-label text-black">
          <img src="{{ asset('storage/'.$data->avatar) }}" class="img-thumbnail rounded-circle" alt="avatar" style="width: 130px; height: 130px;" >
        </label>
      </div>
      <div class="p-2 flex-grow-1 mb-3">
        <h3 class="text-center">{{Auth::user()->name}}</h3>
      </div>
    
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label text-black">Email </label>
            <input type="email" class="form-control" id="exampleFormControlInput1" value="{{Auth::user()->email}}" disabled>
          </div>
          
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label text-black">Giới tính</label>
            <input type="text" class="form-control" value="{{Auth::user()->gender_name}}" disabled>
          </div>

        </div>

        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label text-black">Bộ phận</label>
            <input type="text" class="form-control" value="{{Auth::user()->department_name}}" disabled>
          </div>

        </div>

        <div class="col-md-6">
          <div class="mb-3 ">
            <label class="form-label text-black">Ngày sinh</label>
            <input type="text" class="form-control" value="{{date_format(Auth::user()->birthday,'d-m-Y')}}" disabled>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label text-black">Quê quán</label>
          <input type="text" class="form-control" value="{{Auth::user()->address}}" disabled>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label text-black">Đã đọc</label>
            <input type="text" class="form-control" value="{{ isset($read) ? $read : '' }}" disabled>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label text-black">Đóng góp</label>
            <input type="text" class="form-control" value="{{ isset($contributed) ? $contributed : '' }}" disabled>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label text-black">Ghi chú</label>
          <textarea type="text" class="form-control" disabled>{{Auth::user()->note}}</textarea>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

