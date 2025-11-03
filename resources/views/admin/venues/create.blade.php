@extends('admin.layouts.master')

@section('content')
<div class="contents">
    <div class="demo2 mb-25 t-thead-bg">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Add Venue</h4>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card card-default card-md mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6>Add New Venue</h6>
                            <a href="{{ route('admin.venues.index') }}" class="btn btn-light btn-default btn-squared">Back to List</a>
                        </div>

                        <div class="card-body py-md-30">
                            <form method="POST" action="{{ route('admin.venues.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-25">
                                        <label>Title</label>
                                        <input type="text" name="title" value="{{ old('title') }}" class="form-control" placeholder="Venue title">
                                    </div>


                                    <div class="col-md-6 mb-25">
                                        <label>Venue Owner</label>
                                        <input type="text" name="venue_owner" value="{{ old('venue_owner') }}" class="form-control" placeholder="Owner name">
                                    </div>

                                    <div class="col-md-6 mb-25">
                                        <label>Venue Location</label>
                                        <input type="text" name="venue_location" value="{{ old('venue_location') }}" class="form-control" placeholder="Location">
                                    </div>

                                    <div class="col-md-6 mb-25">
                                        <label>Featured Image</label>
                                        <input type="file" name="featured_image" class="form-control">
                                    </div>

                                    <div class="col-md-6 mb-25">
                                        <label>Gallery (Multiple)</label>
                                        <input type="file" name="gallery[]" multiple class="form-control">
                                    </div>

                                    <div class="col-md-12 mb-25">
                                        <label>Short Description</label>
                                        <textarea name="short_description" class="form-control" rows="3">{{ old('short_description') }}</textarea>
                                    </div>

                                    <div class="col-md-12 mb-25">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="button-group d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">Save</button>
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
