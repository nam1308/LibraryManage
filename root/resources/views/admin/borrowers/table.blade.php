<div class="overflow-x-auto">
    <table class="table align-items-center mb-0">
        <thead>
        <tr>
            <th class="text-secondary text-center font-weight-bolder">
                <str>STT</str>
            </th>
            <th class="text-secondary text-center font-weight-bolder">
                <str>Mã sách</str>
            </th>
            <th class="text-secondary font-weight-bolder">
                <str>Tên sách</str>
            </th>
            <th class="text-secondary font-weight-bolder">
                <str>Người mượn</str>
            </th>
            <th class="text-secondary text-center font-weight-bolder">
                <str>Ngày mượn</str>
            </th>
            <th class="text-secondary text-center font-weight-bolder">
                <str>Ngày trả</str>
            </th>
            <th class="text-secondary text-center font-weight-bolder">
                <str>Trạng thái</str>
            </th>
        </tr>
        </thead>
        <tbody>
        @if(count($borrowers) > 0)
            @foreach($borrowers as $index => $borrower)
                <tr class="pt-2 pb-2">
                    <td class="stt text-center">
                        {{ $index + 1 }}
                    </td>
                    <td class="id text-center">
                        <a href="{{route('admin.books.details',['id' => $borrower->book_id])}}">
                            {{ optional($borrower->book)->book_cd }}
                        </a>
                    </td>
                    <td class="name">
                        {{ optional($borrower->book)->name }}
                    </td>
                    <td class="borrower">
                        {{ optional($borrower->users)->name }}
                    </td>
                    <td class="borrowingDate text-center">
                        {{ !empty($borrower->from_date)?$borrower->from_date->format('d-m-Y') : '' }}
                    </td>
                    <td class="payDay text-center">
                        {{ !empty($borrower->to_date)?$borrower->to_date->format('d-m-Y') : '' }}
                    </td>
                    <td class="Status text-center fw-bold">
                        {!! $borrower->status_name ?? '' !!}
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
@if($countBorrowers > 10)
    @include('admin.borrowers.paninate')
@endif