<div class="overflow-x-auto">
    <table class="table align-items-center mb-0">
        <thead>
        <tr>
            <th class="text-secondary text-center font-weight-bolder opacity-7">
                Mã thể loại
            </th>
            <th class="text-secondary text-center font-weight-bolder opacity-7">
                Tên thể loại
            </th>
            @if (!isset($status))
                <th class="text-secondary text-center font-weight-bolder opacity-7">
                    Trạng thái
                </th>
            @endif
            <th class="text-secondary text-center font-weight-bolder opacity-7">
                Ngày tạo
            </th>
            <th class="text-secondary text-center font-weight-bolder opacity-7">
                Ngày cập nhật
            </th>
            <th class="text-secondary text-center opacity-7"></th>
        </tr>
        </thead>
        <tbody>
        @if(count($categories) > 0)
            @foreach($categories as $category)
                <tr>
                    <td class="text-center">
                        {{ $category->category_cd }}
                    </td>
                    <td class="text-center">
                        {{ $category->name }}
                    </td>
                    @if (!isset($status))
                        <td class="text-center">
                            {!! $category->status_name ?? '' !!}
                        </td>
                    @endif
                    <td class="text-center">
                        {{ !empty($category->created_at) ? $category->created_at->format('d-m-Y') : '' }}
                    </td>
                    <td class="text-center">
                        {{ !empty($category->updated_at) ? $category->updated_at->format('d-m-Y') : '' }}
                    </td>
                    <td class="text-center">
                        <div class="">
                            <a class="btn btn-sm btn-info my-0 mx-1 btn-update"
                                onclick="getData({{ $category->id }})"
                                data-bs-target="#create-update-modal" 
                                data-id="{{ $category->id }}"
                                data-action="{{ route('admin.categories.update', ['id' => $category->id]) }}"
                            >
                                <i class="fas fa-edit"></i>
                            </a>
                            <a  class="btn btn-sm btn-danger my-0 mx-1 btn-delete"
                                data-bs-toggle="modal"
                                data-bs-target="#delete-modal" 
                                data-name="{{ $category->name }}"
                                data-action="{{ route('admin.categories.delete', ['id' => $category->id]) }}" 
                            >
                                <i class="fas fa-trash-alt"></i>
                            </a>
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
<div id="paginator" class="card-footer py-3">
    @if (count($categories) > 0 && $categories->lastPage() > 1)
        @include('admin.categories.paginate')
    @endif
</div>
