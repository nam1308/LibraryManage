<div class="overflow-x-auto">
    <table class="table align-items-center mb-0">
        <thead>
        <tr>
            <th class="text-secondary text-center font-weight-bolder opacity-7">
                Mã người dùng
            </th>
            <th class="text-secondary text-center font-weight-bolder opacity-7">
                Họ tên
            </th>
            <th class="text-secondary text-center font-weight-bolder opacity-7">
                Ảnh cá nhân
            </th>
            <th class="text-secondary text-center font-weight-bolder opacity-7">
                Email
            </th>
            <th class="text-secondary text-center font-weight-bolder opacity-7">
                Bộ phận
            </th>
            <th class="text-secondary text-center font-weight-bolder opacity-7">
                Trạng thái
            </th>
            <th class="text-secondary text-center font-weight-bolder opacity-7">
                Ngày cập nhật
            <th class="text-secondary text-center opacity-7"></th>
        </tr>
        </thead>
        <tbody>
        @if(count($users) > 0)
            @foreach($users as $user)
                <tr>
                    <td class="id text-center">
                        <a href="{{ route('admin.users.show', $user->id) }}">
                            {{ $user->employee_id }}
                        </a>
                    </td>
                    <td class="name text-center">
                        {{ $user->name }}
                    </td>
                    <td>
                        <div class="text-center">
                            <img src="{{ URL::asset('storage/'.$user->avatar) }}"
                                 class="avatar avatar-xl" alt="user1">
                        </div>
                    </td>
                    <td class="email text-center">
                        {{ $user->email }}
                    </td>
                    <td class="department text-center">
                        {{ $user->department_name ?? '' }}
                    </td>
                    <td class="status text-center">
                       {!! $user->status_name ?? '' !!}
                    </td>
                    <td class="status text-center">
                        {{ !empty($user->updated_at)?$user->updated_at->format('d-m-Y') : '' }}
                    </td>
                    <td class="text-right">
                        <div class="d-flex pe-3 justify-content-end">
                            @if($user->status != App\Enums\UserEnums::STATUS_INACTIVE)
                                @if($user->status != App\Enums\UserEnums::STATUS_BLOCK)
                                    <button class="btn font-icon btn-sm btn-info openEditModal mb-0"
                                            onclick="getData({{ $user->id }})"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a class="btn m-0 font-icon btn-sm btn-warning mx-1" href="#" id="block-btn-user"
                                       data-bs-toggle="modal"
                                       data-id="{{ $user->id }}" data-email="{{ $user->email }}"
                                       data-bs-target="#block-modal">
                                        <i class="fas fa-ban"></i>
                                    </a>
                                @else
                                    <a class="btn m-0 btn-sm btn-success mx-1" data-id="{{ $user->id }}" href="#"
                                       id="unBlock-btn-user" data-email="{{ $user->email }}"
                                       data-bs-toggle="modal"
                                       data-bs-target="#unblock-modal">
                                        <i class="fas fa-lock-open"></i>
                                    </a>
                                @endif
                                <a id="btn-delete" class="btn font-icon m-0 btn-sm btn-danger" data-bs-toggle="modal"
                                   data-bs-target="#delete-modal" data-id="{{ $user->id }}"
                                   data-email="{{ $user->email }}">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="8">Không có dữ liệu</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
@if (count($users) > 0)
    @include('admin.users.paginate')
@endif
