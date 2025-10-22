@if ($errors->any())
<div class="alert-big alert alert-danger  alert-dismissible fade show " role="alert">
    <div class="alert-content">
        <h6 class="alert-heading">Errors</h6>
        <strong>Please fix the following validation errors</strong>
        
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        <button type="button" class="btn-close text-capitalize" data-bs-dismiss="alert" aria-label="Close">
        <!-- <img src="{{ asset('img/svg/x.svg') }}" alt="x" class="svg" aria-hidden="true"> -->
        </button>

    </div>
</div>
@endif