@push('styles')
    <link href="{{ asset('css/admin/users/uploadImage.css') }}" rel="stylesheet" />
@endpush

<div class="w-100 uploadFile position-relative">
    <div class="wrapper {{ isset($data->avatar) ? 'active' : '' }}">
        <div class="image img img_block">
            <img src="{{ isset($data->avatar) ? asset("storage/$data->avatar") : '' }}" alt="" id="imgEditModal" class="img-thumbnail">
        </div>
    </div>
    <input type="text" name="avatar_old" id="avatar_old" value="{{ isset($data) ? $data->avatar : '' }}" hidden>
    <div class="w-100 uploadFile_content image-none">
        <label class="uploadFile_btn bg-gradient-danger custom-btn">
           Chọn ảnh
        </label>
        <input class="ipt-avatar" type="file" name="image" value="{{ isset($data) ? $data->avatar : '' }}" hidden>
    </div>
</div>