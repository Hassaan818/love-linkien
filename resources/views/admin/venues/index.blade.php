@extends('admin.layouts.master')

@section('content')
<div class="contents">
    <div class="demo2 mb-25 t-thead-bg">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-lg-12">
                    <div class="breadcrumb-main d-flex justify-content-between align-items-center">
                        <h4 class="text-capitalize breadcrumb-title mb-0">Venues</h4>
                        <a href="{{ route('admin.venues.create') }}" class="btn btn-primary btn-sm px-20">
                            <i class="las la-plus-circle me-1"></i> Add Venue
                        </a>
                    </div>
                </div>

                <div class="col-lg-12 mt-3">
                    <div class="card card-default card-md mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6>All Venues</h6>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0 table-borderless">
                                    <thead>
                                        <tr class="userDatatable-header">
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Featured Image</th>
                                            <th>Owner</th>
                                            <th>Location</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($venues as $venue)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $venue->title }}</td>
                                            <td>
                                                <img src="{{ asset($venue->featured_image) }}" width="50" class="rounded">
                                            </td>
                                            <td>{{ $venue->venue_owner ?? '-' }}</td>
                                            <td>{{ $venue->venue_location }}</td>
                                            <td class="text-end">
                                                <div class="d-inline-flex gap-2">
                                                    <a href="{{ route('admin.venues.edit', $venue->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <form method="POST" action="{{ route('admin.venues.destroy', $venue->id) }}" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this venue?')">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">No venues found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="mt-3">
                                    {{ $venues->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
