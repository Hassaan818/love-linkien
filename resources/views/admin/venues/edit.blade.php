@extends('admin.layouts.master')

@section('content')
<div class="contents">
    <div class="demo2 mb-25 t-thead-bg">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Edit Venue</h4>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card card-default card-md mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6>Edit Venue</h6>
                            <a href="{{ route('admin.venues.index') }}" class="btn btn-light btn-default btn-squared">
                                Back to List
                            </a>
                        </div>

                        <div class="card-body py-md-30">
                            <form method="POST" action="{{ route('admin.venues.update', $venue->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <!-- Title -->
                                    <div class="col-md-6 mb-25">
                                        <label class="il-gray fs-14 fw-500 mb-10">Title</label>
                                        <input type="text" name="title" value="{{ old('title', $venue->title) }}" class="form-control ih-medium ip-gray radius-xs b-light px-15" placeholder="Venue title">
                                    </div>


                                    <div class="col-md-6 mb-25">
                                        <label class="il-gray fs-14 fw-500 mb-10">Slug (Should be unique and according to the title)</label>
                                        <!-- <label></label> -->
                                        <input type="text" name="slug" value="{{ old('slug', $venue->slug) }}" class="form-control" placeholder="Venue Slug">
                                    </div>

                                    <!-- Owner -->
                                    <div class="col-md-6 mb-25">
                                        <label class="il-gray fs-14 fw-500 mb-10">Venue Owner</label>
                                        <input type="text" name="venue_owner" value="{{ old('venue_owner', $venue->venue_owner) }}" class="form-control ih-medium ip-gray radius-xs b-light px-15" placeholder="Owner name">
                                    </div>

                                    <!-- Location -->
                                    <div class="col-md-6 mb-25">
                                        <label class="il-gray fs-14 fw-500 mb-10">Venue Location</label>
                                        <input type="text" name="venue_location" value="{{ old('venue_location', $venue->venue_location) }}" class="form-control ih-medium ip-gray radius-xs b-light px-15" placeholder="Location">
                                    </div>

                                    <!-- Featured Image -->
                                    <div class="col-md-6 mb-25">
                                        <label class="il-gray fs-14 fw-500 mb-10">Featured Image</label>
                                        <input type="file" name="featured_image" class="form-control ih-medium ip-gray radius-xs b-light px-15">
                                        @if($venue->featured_image)
                                        <div class="mt-2">
                                            <img src="{{ asset($venue->featured_image) }}" alt="Current Image" width="100" class="rounded shadow-sm">
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Gallery -->
                                    <div class="col-md-6 mb-25">
                                        <label class="il-gray fs-14 fw-500 mb-10">Gallery (Multiple)</label>
                                        <input type="file" name="gallery[]" multiple class="form-control ih-medium ip-gray radius-xs b-light px-15">
                                        @if($venue->gallery)
                                        <div class="mt-2 d-flex flex-wrap gap-2">
                                            @foreach(json_decode($venue->gallery, true) as $image)
                                            <img src="{{ asset($image) }}" alt="Gallery Image" width="70" class="rounded shadow-sm">
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Short Description -->
                                    <div class="col-md-12 mb-25">
                                        <label class="il-gray fs-14 fw-500 mb-10">Short Description</label>
                                        <textarea name="short_description" class="form-control ih-medium ip-gray radius-xs b-light px-15" rows="3" placeholder="Short description">{{ old('short_description', $venue->short_description) }}</textarea>
                                    </div>

                                    <!-- Description -->
                                    <div class="col-md-12 mb-25">
                                        <label class="il-gray fs-14 fw-500 mb-10">Description</label>
                                        <textarea name="description" class="form-control ih-medium ip-gray radius-xs b-light px-15" rows="5" placeholder="Full description">{{ old('description', $venue->description) }}</textarea>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="col-md-12">
                                        <div class="button-group d-flex justify-content-end">
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