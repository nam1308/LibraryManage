    <table class="table align-items-center mb-0">
        <thead>
        <tr>
            <th class="text-secondary text-center font-weight-bolder">
                Mã Sách
            </th>
            <th class="text-secondary font-weight-bolder">
                Tên Sách
            </th>
            <th class="text-secondary font-weight-bolder">
                Tác Giả 
            </th>
            <th class="text-secondary text-center font-weight-bolder">
                Ngày Mượn
            </th>
            <th class="text-secondary text-center font-weight-bolder">
                Ngày Trả
            </th>
            <th class="text-secondary font-weight-bolder">
                Trạng thái
            </th>
        </tr>
        </thead>
        <tbody>
        @if(count($borrowers) > 0)
            @foreach($borrowers as $borrow)
                
                    <tr style="line-height: 36px">
                        <td class="name text-center">
                            @if($borrow->book->deleted_at == null)
                                <a href="{{URL::to('book/details/'.$borrow->book->id)}}" style="font-weight: 500">
                                    {{$borrow->book->book_cd}}
                                </a>
                            @else
                                {{$borrow->book->book_cd}}
                            @endif
                        </td>
                        <td class="email" style="max-width: 180px; overflow: hidden;">
                            {{ Illuminate\Support\Str::limit($borrow->book->name, $limit = 20, $end = '...') }}
                        </td>
                        <td class="department" style="max-width: 180px; overflow: hidden;">
                            {{ Illuminate\Support\Str::limit($borrow->book->author, $limit = 20, $end = '...') }}
                        </td>
                        <td class="status text-center">
                            {{date_format( new DateTime($borrow->from_date),'H:i d-m-Y')}}
                        </td>
                        <td class="status text-center">
                            @if(($borrow->status == config('constants.STATUS_BORROWER_0')) && ($borrow->allowed_renewal != config('constants.ALLOWED_RENEWAL_0')))
                                {{date_format( new DateTime($borrow->extended_date),'d-m-Y')}}
                            @elseif($borrow->status == config('constants.STATUS_BORROWER_2'))
                                {{date_format( new DateTime($borrow->extended_date),'d-m-Y')}}
                            @else
                                {{date_format( new DateTime($borrow->to_date),'d-m-Y')}}
                            @endif
                        </td>
                        <td class="status fw-bold" style="padding-left: 26px">
                            {!! $borrow->status_name !!}
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

@if (count($borrowers) > 0 && $borrowers->lastPage() > 1)    
    @include('users.paginate')
@endif
