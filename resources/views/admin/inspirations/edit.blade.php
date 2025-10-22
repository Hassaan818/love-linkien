@extends('admin.layouts.master')

@section('content')
<div class="contents">
    <div class="container-fluid">
        <div class="card card-default card-md mb-4">
            <div class="card-header">
                <h6>Edit Inspiration</h6>
            </div>

            <div class="card-body py-md-30">
                <form method="POST" action="{{ route('admin.inspirations.update', $inspiration->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        {{-- Category --}}
                        <div class="col-md-6 mb-25">
                            <label class="il-gray fs-14 fw-500 align-center mb-10">Category</label>
                            <select name="category_id" class="form-control select2">
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $inspiration->category_id == $category->id ? 'selected' : '' }}>
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
                                value="{{ old('name', $inspiration->name) }}"
                                class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                required>
                            @error('name')
                            <span class="text-danger fs-13">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Slug --}}
                        <div class="col-md-6 mb-25">
                            <label class="il-gray fs-14 fw-500 align-center mb-10">Slug</label>
                            <input
                                type="text"
                                name="slug"
                                value="{{ old('slug', $inspiration->slug) }}"
                                class="form-control ih-medium ip-gray radius-xs b-light px-15">
                            @error('slug')
                            <span class="text-danger fs-13">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Short Description --}}
                        <div class="col-md-12 mb-25">
                            <label class="il-gray fs-14 fw-500 align-center mb-10">Short Description</label>
                            <textarea
                                name="short_description"
                                rows="3"
                                class="form-control ih-medium ip-gray radius-xs b-light px-15">{{ old('short_description', $inspiration->short_description) }}</textarea>
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
                                class="form-control ih-medium ip-gray radius-xs b-light px-15">{{ old('notes', $inspiration->notes) }}</textarea>
                            @error('notes')
                            <span class="text-danger fs-13">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Tags --}}
                        <div class="col-md-6 mb-25">
                            <div class="form-group tagSelect-rtl">
                                <label class="il-gray fs-14 fw-500 align-center mb-10">Tags</label>
                                <div class="dm-select">
                                    <select name="tags[]" id="select-tag" class="form-control select2" multiple>
                                        @php
                                        $selectedTags = json_decode($inspiration->tags ?? '[]');
                                        @endphp
                                        @foreach($selectedTags as $tag)
                                        <option value="{{ $tag }}" {{ in_array($tag, $selectedTags) ? 'selected' : '' }}>
                                            {{ $tag }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('tags')
                            <span class="text-danger fs-13">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Image --}}
                        <div class="col-md-6 mb-25">
                            <label class="il-gray fs-14 fw-500 align-center mb-10">Image</label><br>

                            <input type="file" name="image" class="form-control ih-medium ip-gray radius-xs b-light px-15">
                            @error('image')
                            <span class="text-danger fs-13">{{ $message }}</span>
                            @enderror

                            @if($inspiration->image)
                            <img src="{{ asset($inspiration->image) }}" alt="Image" width="100" class="mb-2 rounded">
                            @endif
                        </div>

                        {{-- Submit --}}
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
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select or type tags",
            tags: true,
            tokenSeparators: [',']
        });
    });
</script>
@endsection