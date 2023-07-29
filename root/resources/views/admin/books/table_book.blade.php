<div class="overflow-x-auto">
    <table class="table align-items-center mb-0">
        <thead>
            <tr>
                <th class="text-secondary text-center font-weight-bolder">
                    <str>Mã sách</str>
                </th>
                <th class="text-secondary text-center font-weight-bolder">
                    <str>Tên sách</str>
                </th>
                <th class="text-secondary text-center font-weight-bolder">
                    <str>Hình ảnh</str>
                </th>
                <th class="text-secondary text-center font-weight-bolder">
                    <str>Tác giả</str>
                </th>
                <th class="text-secondary text-center font-weight-bolder">
                    <str>Loại</str>
                </th>
                <th class="text-secondary text-center font-weight-bolder">
                    <str>Số lượng</str>
                </th>
                <th class="text-secondary text-center font-weight-bolder">
                    <str>Trạng thái</str>
                </th>
                <th class="text-secondary text-center font-weight-bolder">
                    <str>Ngày tạo</str>
                </th>
                <th class="text-secondary text-center font-weight-bolder"></th>
            </tr>
        </thead>
        <tbody>
            @if(count($books) > 0)
                @foreach($books as $book)
                    <tr class="pt-2 pb-2">
                        <td class="id text-center">
                            <a href="{{route('admin.books.details',['id' => $book->id])}}" >
                                {{ isset($book->book_cd) ? $book->book_cd : '' }}
                            </a>
                        </td>
                        <td class="name text-center">
                            {{ isset($book->name) ? $book->name : '' }}
                        </td>
                        <td>
                            <div class="text-center img_block_book">
                                <img src="{{ isset($book->image) ? URL::asset('storage/'.$book->image) : '' }}"
                                     class="" alt="" />
                            </div>
                        </td>
                        <td class="text-center">
                            {{ isset($book->author) ? $book->author : '' }}
                        </td>
                        <td class="category">
                            <ul class="mb-0" style="list-style: none">
                                @if(count($book->categories) > 0)
                                    @foreach($book->categories as $cate)
                                        <li>
                                            {{ $cate->name }}
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </td>
                        <td class="quantity text-center">
                            {{ isset($book->quantity) ? $book->quantity : '' }}
                        </td>
                        <td class="status text-center {{ isset($book->deleted_at) ? 'text-danger' : ($book->quantity > $book->borrowers_count ? 'text-success' : 'text-danger') }}">
                            {{ $book->deleted_at ? 'Đã xóa' : ($book->quantity > $book->borrowers_count ? 'Đang còn' : 'Đã hết') }}
                        </td>
                        <td class="created_at text-center">
                            {{ isset($book->created_at) ? $book->created_at->format('d-m-Y') : '' }}
                        </td>
                        <td class="text-right">
                            <div class="d-flex pe-3 justify-content-end">
                                @if($book->deleted_at === null)
                                    <button class="btn btn-sm btn-info btn-edit-book openEditModal mb-0 m-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#edit-book"
                                            data-id="{{ $book->id  }}"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button id="btn-delete" class="btn m-0 btn-sm btn-danger mb-0 m-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#delete-modal"
                                        data-id="{{ $book->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="9">Không có dữ liệu</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@if($countBook > 10)
    @include('admin.books.paginate')
@endif