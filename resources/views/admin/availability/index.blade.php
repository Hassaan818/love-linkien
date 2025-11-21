@extends('admin.layouts.master')

@section('content')
<div class="contents">
    <div class="demo2 mb-25 t-thead-bg">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Availability List</h4>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card card-default card-md mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6>All Availability</h6>
                            <a href="{{ route('admin.availability.create') }}" class="btn btn-primary btn-default btn-squared">
                                + Add Availability
                            </a>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead class="bg-white">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Time Slots</th>
                                        <th>Users</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($availabilities as $index => $availability)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $availability->date }}</td>
                                            <td>
                                                @foreach ($availability->slots as $slot)
                                                    <span class="rounded-pill bg-primary text-white px-2 py-1 m-1">
                                                        {{ $slot->start_time }} - {{ $slot->end_time }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td>{{ $availability->user->name }}</td>
                                            <td>
                                                <a href="{{ route('admin.availability.edit', $availability->id) }}"
                                                   class="btn btn-info btn-sm">Edit</a>

                                                <form method="POST"
                                                      action="{{ route('admin.availability.destroy', $availability->id) }}"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            onclick="return confirm('Are you sure?')"
                                                            class="btn btn-danger btn-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                No availability added yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{ $availabilities->links() }} <!-- Pagination -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
