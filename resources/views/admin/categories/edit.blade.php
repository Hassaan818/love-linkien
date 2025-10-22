@extends('admin.layouts.master')

@section('content')
<div class="contents">
    <div class="demo2 mb-25 t-thead-bg">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Edit Category</h4>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card card-default card-md mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6>Edit Category</h6>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-light btn-default btn-squared">
                                Back to List
                            </a>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-25 offset-md-2">
                                @include('admin.partials.success-messages')
                                @include('admin.partials.validation-error-messages')
                            </div>
                        </div>

                        <div class="card-body py-md-30">
                            <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6 mb-25">
                                        <label class="il-gray fs-14 fw-500 align-center mb-10">Name</label>
                                        <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control ih-medium ip-gray radius-xs b-light px-15" placeholder="Category Name">
                                    </div>

                                    <div class="col-md-6 mb-25">
                                        <label class="il-gray fs-14 fw-500 align-center mb-10">Slug</label>
                                        <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="form-control ih-medium ip-gray radius-xs b-light px-15" placeholder="Slug">
                                    </div>

                                    <div class="col-md-12 mb-25">
                                        <label class="il-gray fs-14 fw-500 align-center mb-10">Description</label>
                                        <textarea name="description" class="form-control ih-medium ip-gray radius-xs b-light px-15" placeholder="Description">{{ old('description', $category->description) }}</textarea>
                                    </div>

                                    <div class="col-md-6 mb-25">
                                        <label class="il-gray fs-14 fw-500 align-center mb-10">Image</label>
                                        <input type="file" name="image" class="form-control ih-medium ip-gray radius-xs b-light px-15">
                                        @if($category->image)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image" width="80">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-12">
                                        <div class="button-group d-flex pt-sm-25 justify-content-md-end justify-content-start">
                                            <button type="submit" class="btn btn-primary btn-default btn-squared text-capitalize radius-md shadow2 btn-sm">
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- ends: card -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
