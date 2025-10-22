@extends('admin.layouts.master')

@section('content')
<div class="contents">
    <div class="container-fluid">
        <div class="card card-default card-md mb-4">
            <div class="card-header">
                <h6>Inspiration Details</h6>
            </div>

            <div class="card-body">
                <div class="mb-3"><strong>Name:</strong> {{ $inspiration->name }}</div>
                <div class="mb-3"><strong>Slug:</strong> {{ $inspiration->slug }}</div>
                <div class="mb-3"><strong>Category:</strong> {{ $inspiration->category->name ?? 'N/A' }}</div>
                <div class="mb-3"><strong>Short Description:</strong> {{ $inspiration->short_description }}</div>
                <div class="mb-3"><strong>Notes:</strong> {{ $inspiration->notes ?? 'N/A' }}</div>
                <div class="mb-3">
                    <strong>Tags:</strong>
                    @if($inspiration->tags)
                        @foreach(json_decode($inspiration->tags) as $tag)
                            <span class="rounded-pill p-1 bg-primary text-white">{{ $tag }}</span>
                        @endforeach
                    @endif
                </div>
                <div class="mb-3">
                    <strong>Image:</strong><br>
                    @if($inspiration->image)
                        <img src="{{ asset($inspiration->image) }}" width="200" class="rounded">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </div>

                <a href="{{ route('admin.inspirations.index') }}" class="btn btn-secondary btn-sm mt-3">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
