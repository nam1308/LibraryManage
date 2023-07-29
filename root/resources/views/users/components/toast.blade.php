<div class="position-fixed top-0 end-0 p-3" style="z-index: 1021">
    <div id="toastSuccess" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
        <div class="toast-header">
            <img src="{{ asset('img/users/anh_logo.png') }}" class="rounded avatar avatar-sm me-2" alt="..." >
            <strong class="me-auto" id="titleSuccess">
            </strong>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
        <div class="toast-body text-white bg-success border-0" id="contentSuccess">
        </div>
    </div>
</div>


<div class="position-fixed top-0 end-0 p-3" style="z-index: 1021">
    <div id="toastFail" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
        <div class="toast-header">
            <img src="<?php echo e(asset('img/users/anh_logo.png')); ?>" class="avatar avatar-sm  me-3 " alt="...">
            <strong class="me-auto" id="titleFail">
            </strong>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
        <div class="toast-body text-white bg-danger border-0" id="contentFail">
        </div>
    </div>
</div>
@push('js')
<script>
    $(document).ready(function () {
        @if(Session::has('titleSuccess') && Session::has('contentSuccess'))
            var data ={
                "title":"{{ Session::get('titleSuccess') }}",
                "message":"{{ Session::get('contentSuccess') }}",
            };
            showToastSuccess(data);
        @endif
        
        @if(Session::has('titleFail') && Session::has('contentFail'))
            var data ={
                "title":"{{ Session::get('titleFail') }}",
                "message":"{{ Session::get('contentFail') }}",
            }
            showToastFail(data);
        @endif
    });
 </script>
@endpush
