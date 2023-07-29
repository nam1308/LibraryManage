<div class="toast-container position-fixed top-0 end-0 p-3 z-index-99999" >
	<div id="messageToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" and data-bs-delay="2000">
		<div class="toast-header rounded-top">
			<strong class='me-auto'></strong>
			<button type="button" class="btn-close btn-close-toast" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
		<div class="toast-body bg-light-subtle rounded-bottom" >
		</div>
	</div>
</div>
@push('scripts')
	@if(Session::has('class') && Session::has('message'))
		<script>
			var data = {
				status : ("{{ Session::get('class') }}" == "bg-gradient-warning text-white") ? 0 : 1 ,
				message : "{{ Session::get('message') }}",
			};
			showMessageToast( data, "{{ Session::get('class') }}");
		</script>
	@endif
@endpush