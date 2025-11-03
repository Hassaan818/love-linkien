@extends('admin.layouts.master')

@section('content')
<div class="contents">

    <div class="demo2 mb-25 t-thead-bg">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Meetings</h4>
                    </div>

                </div>

                <div class="col-lg-12">
                    <div class="card card-default card-md mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6>All Meetings</h6>
                            <!-- Optional Add button -->

                        </div>

                        <div class="card-body">
                            @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table mb-0 table-borderless">
                                    <thead>
                                        <tr class="userDatatable-header">
                                            <th><span class="userDatatable-title">#</span></th>
                                            <th><span class="userDatatable-title">Venue</span></th>
                                            <th><span class="userDatatable-title">User</span></th>
                                            <th><span class="userDatatable-title">Meeting Date</span></th>
                                            <th><span class="userDatatable-title">Start Time</span></th>
                                            <th><span class="userDatatable-title">End Time</span></th>
                                            <th><span class="userDatatable-title">Email</span></th>
                                            <th><span class="userDatatable-title float-end">Actions</span></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($meetings as $meeting)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $meeting->venue->title ?? '—' }}</td>
                                            <td>{{ $meeting->user->name ?? '—' }}</td>
                                            <td>{{ $meeting->meeting_date }}</td>
                                            <td>{{ $meeting->start_time }}</td>
                                            <td>{{ $meeting->end_time }}</td>
                                            <td>{{ $meeting->email }}</td>

                                            <td class="text-end">
                                                <div class="d-inline-flex gap-2">

                                                <a href="{{ route('admin.meetings.show', [$meeting->id]) }}" class="btn btn-sm btn-primary">Show</a>
                                                    <form method="POST" action="{{ route('admin.meetings.destroy', $meeting->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this meeting?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="11" class="text-center text-muted py-3">No meetings found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $meetings->links() }}
                            </div>
                        </div>
                    </div>
                    <!-- ends: card -->
                </div>
            </div>
        </div>
    </div>

</div>
@endsection