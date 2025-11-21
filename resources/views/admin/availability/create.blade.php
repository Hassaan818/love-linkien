@extends('admin.layouts.master')

@section('content')
<div class="contents">
    <div class="demo2 mb-25 t-thead-bg">
        <div class="container-fluid">
            @include('admin.partials.success-messages')
            @include('admin.partials.validation-error-messages')

            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Add Availability</h4>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card card-default card-md mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6>Add New Availability</h6>
                            <a href="{{ route('admin.availability.index') }}" class="btn btn-light btn-default btn-squared">
                                Back to List
                            </a>
                        </div>

                        <div class="card-body py-md-30">
                            <form method="POST" action="{{ route('admin.availability.store') }}">
                                @csrf

                                <!-- Admin Select -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label>Select Admin User</label>
                                        <select name="user_id" class="form-control" required>
                                            <option value="">-- Select Admin --</option>
                                            @foreach ($admins as $admin)
                                                <option value="{{ $admin->id }}">{{ $admin->name }} ({{ $admin->email }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Availability Row -->
                                <div class="border rounded p-3 mb-3">
                                    <div class="row">

                                        <div class="col-md-4 mb-25">
                                            <label>Select Date</label>
                                            <input type="date" name="date" class="form-control" min="{{ date('Y-m-d') }}" required>
                                        </div>

                                        <div class="col-md-8 mb-25">
                                            <label>Time Slots</label>
                                            <div class="slot-container">
                                                <div class="d-flex mb-2 slot-row">
                                                    <input type="time" name="slots_start[]" class="form-control w-50" required>
                                                    <input type="time" name="slots_end[]" class="form-control w-50 ms-2" required>
                                                    <button type="button" class="btn btn-danger btn-sm ms-2 remove-slot">X</button>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-primary btn-sm add-slot">+ Add Slot</button>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <div class="button-group d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Save Availability</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("click", function(e) {

    // Add Slot
    if (e.target.classList.contains("add-slot")) {
        let container = document.querySelector(".slot-container");

        let slotRow = `
        <div class="d-flex mb-2 slot-row">
            <input type="time" name="slots_start[]" class="form-control w-50" required>
            <input type="time" name="slots_end[]" class="form-control w-50 ms-2" required>
            <button type="button" class="btn btn-danger btn-sm ms-2 remove-slot">X</button>
        </div>
        `;
        container.insertAdjacentHTML("beforeend", slotRow);
    }

    // Remove Slot
    if (e.target.classList.contains("remove-slot")) {
        e.target.closest(".slot-row").remove();
    }

});
</script>
@endsection
