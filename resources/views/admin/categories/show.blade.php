@extends('admin.layouts.master')

@section('content')
<div class="contents">
    <div class="demo2 mb-25 t-thead-bg">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Category Details</h4>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card card-default card-md mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6>Category Information</h6>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-light btn-default btn-squared">
                                Back to List
                            </a>
                        </div>

                        <div class="card-body py-md-30">
                            <div class="row">
                                <div class="col-md-6 mb-25">
                                    <strong>Name:</strong>
                                    <p>{{ $category->name }}</p>
                                </div>

                                <div class="col-md-6 mb-25">
                                    <strong>Slug:</strong>
                                    <p>{{ $category->slug }}</p>
                                </div>

                                <div class="col-md-12 mb-25">
                                    <strong>Description:</strong>
                                    <p>{{ $category->description ?? 'No description available.' }}</p>
                                </div>

                                <div class="col-md-6 mb-25">
                                    <strong>Image:</strong><br>
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image" width="100">
                                    @else
                                        <span class="text-muted">No image uploaded</span>
                                    @endif
                                </div>

                                <div class="col-md-12 mt-3">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-light btn-sm">Back</a>
                                </div>
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
