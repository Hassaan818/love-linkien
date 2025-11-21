@extends('admin.layouts.master')

@section('content')
<div class="contents">
    <div class="container-fluid">
        <div class="card card-default card-md mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6>Meeting Details</h6>
                <a href="{{ route('admin.meetings.index') }}" class="btn btn-sm btn-secondary">Back</a>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Meeting With:</strong> {{ $meeting->adminUser->name ?? '—' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>User:</strong> {{ $meeting->user->name ?? '—' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Meeting Date:</strong> {{ $meeting->meeting_date }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Start Time:</strong> {{ \Carbon\Carbon::parse($meeting->start_time)->format('h:i A') }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>End Time:</strong> {{ \Carbon\Carbon::parse($meeting->end_time)->format('h:i A') }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Name:</strong> {{ $meeting->name }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Phone:</strong> {{ $meeting->phone }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Email:</strong> {{ $meeting->email }}
                    </div>

                    <div class="col-md-12 mb-3">
                        <strong>Description:</strong><br>
                        @if($meeting->description)
                        <p class="mt-2">{{ $meeting->description }}</p>
                        @else
                        <span class="text-muted">No description provided.</span>
                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection