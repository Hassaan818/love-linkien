@extends('admin.layouts.master')

@section('content')
<div class="contents">
    <div class="demo2 mb-25 t-thead-bg">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-lg-12">
                    <div class="breadcrumb-main d-flex justify-content-between align-items-center">
                        <h4 class="text-capitalize breadcrumb-title mb-0">Categories</h4>
                        <!-- <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm px-20">
                            <i class="las la-plus-circle me-1"></i> Add Category
                        </a> -->
                    </div>
                </div>

                <div class="col-lg-12 mt-3">
                    <div class="card card-default card-md mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6>All Categories</h6>
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">
                                + Add New
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0 table-borderless">
                                    <thead>
                                        <tr class="userDatatable-header">
                                            <th><span class="userDatatable-title">#</span></th>
                                            <th><span class="userDatatable-title">Name</span></th>
                                            <th><span class="userDatatable-title">Slug</span></th>
                                            <th><span class="userDatatable-title">Image</span></th>
                                            <th><span class="userDatatable-title float-end">Actions</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($categories as $category)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->slug }}</td>
                                            <td>
                                                @if($category->image)
                                                    <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image" width="50" class="rounded">
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <div class="d-inline-flex gap-2">
                                                    <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-sm btn-secondary">Show</a>
                                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">No categories found</td>
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
