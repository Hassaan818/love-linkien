@extends('admin.layouts.master')

@section('content')
<div class="contents">
    <div class="container-fluid">
        <div class="card card-default card-md mb-4">
            <div class="card-header">
                <h6>Add New Inspiration</h6>
            </div>

            <div class="card-body py-md-30">
                <form method="POST" action="{{ route('admin.inspirations.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        {{-- Category --}}
                        <div class="col-md-6 mb-25">
                            <label class="il-gray fs-14 fw-500 align-center mb-10">Category</label>
                            <select name="category_id" class="form-control select2">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <span class="text-danger fs-13">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Name --}}
                        <div class="col-md-6 mb-25">
                            <label class="il-gray fs-14 fw-500 align-center mb-10">Name</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                required>
                            @error('name')
                            <span class="text-danger fs-13">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Short Description --}}
                        <div class="col-md-12 mb-25">
                            <label class="il-gray fs-14 fw-500 align-center mb-10">Short Description</label>
                            <textarea
                                name="short_description"
                                rows="3"
                                class="form-control ih-medium ip-gray radius-xs b-light px-15">{{ old('short_description') }}</textarea>
                            @error('short_description')
                            <span class="text-danger fs-13">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Notes --}}
                        <div class="col-md-12 mb-25">
                            <label class="il-gray fs-14 fw-500 align-center mb-10">Notes</label>
                            <textarea
                                name="notes"
                                rows="3"
                                class="form-control ih-medium ip-gray radius-xs b-light px-15">{{ old('notes') }}</textarea>
                            @error('notes')
                            <span class="text-danger fs-13">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-25">
                            <label class="il-gray fs-14 fw-500 align-center mb-10">Tags</label>
                            <select name="tags[]" id="select-tag" class="form-control select2" multiple>
                                <option value="red">red</option>
                                <option value="green">green</option>
                                <option value="blue">blue</option>
                            </select>
                            @error('tags')
                            <span class="text-danger fs-13">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Image --}}
                        <div class="col-md-6 mb-25">
                            <label class="il-gray fs-14 fw-500 align-center mb-10">Image</label>
                            <input type="file" name="image" class="form-control ih-medium ip-gray radius-xs b-light px-15">
                            @error('image')
                            <span class="text-danger fs-13">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="col-md-12">
                            <div class="button-group d-flex pt-sm-25 justify-content-md-end justify-content-start">
                                <button type="submit" class="btn btn-primary btn-default btn-squared text-capitalize radius-md shadow2 btn-sm">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
$(document).ready(function() {
    $('#select-tag').select2({
        tags: true,
        placeholder: "Type and press Enter...",
        width: '100%',
        tokenSeparators: [',', ' '],
    });
});
</script>
@endsection