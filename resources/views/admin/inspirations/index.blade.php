@extends('admin.layouts.master')

@section('content')
<div class="contents">

    <div class="demo2 mb-25 t-thead-bg">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Inspirations</h4>
                    </div>

                </div>

                <div class="col-lg-12">
                    <div class="card card-default card-md mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6>All Inspirations</h6>
                            <a href="{{ route('admin.inspirations.create') }}" class="btn px-15 btn-primary btn-squared btn-sm">
                                Add Inspiration
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0 table-borderless">
                                    <thead>
                                        <tr class="userDatatable-header">
                                            <th><span class="userDatatable-title">#</span></th>
                                            <th><span class="userDatatable-title">Name</span></th>
                                            <th><span class="userDatatable-title">Category</span></th>
                                            <th><span class="userDatatable-title">Tags</span></th>
                                            <th><span class="userDatatable-title">Image</span></th>
                                            <th><span class="userDatatable-title float-end">Actions</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($inspirations as $inspiration)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $inspiration->name }}</td>
                                            <td>{{ $inspiration->category->name ?? 'N/A' }}</td>
                                            <td>
                                                @if($inspiration->tags)
                                                @foreach(json_decode($inspiration->tags) as $tag)
                                                <span class="rounded-pill p-1 text-white bg-primary">{{ $tag }}</span>
                                                @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                @if($inspiration->image)
                                                <img src="{{ asset($inspiration->image) }}" alt="Image" width="50">
                                                @else
                                                <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <div class="d-inline-flex gap-2">
                                                    <a href="{{ route('admin.inspirations.show', $inspiration->id) }}" class="btn btn-sm btn-secondary">Show</a>
                                                    <a href="{{ route('admin.inspirations.edit', $inspiration->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <form method="POST" action="{{ route('admin.inspirations.destroy', $inspiration->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this inspiration?')">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">No inspirations found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- ends: table card -->

                </div>
            </div>
        </div>
    </div>

</div>
@endsection