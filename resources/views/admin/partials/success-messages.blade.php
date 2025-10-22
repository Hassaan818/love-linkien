@if(session('message'))
<div class="alert-big alert alert-info  alert-dismissible fade show " role="alert">
    <div class="alert-content">
        <h6 class="alert-heading">Success</h6>
        <p>{{ session('message') }}</p>
        <button type="button" class="btn-close text-capitalize" data-bs-dismiss="alert" aria-label="Close">
        <!-- <img src="{{ asset('img/svg/x.svg') }}" alt="x" class="svg" aria-hidden="true"> -->
        </button>

    </div>
</div>
@endif