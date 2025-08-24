@extends('tgg-india.layouts.app')

@section('title', 'Edit Video | TGG Meta | TGG India')

@section('content')
    <div class="admin-container">
        <h4 class="mb-3 trainer-heading">Edit Video</h4>
        @include('tgg-india.layouts.includes.message')

        <div class="card p-3 mb-4">
            <form action="{{ route('tgg-india.trainer.videos.update', $video->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{ $video->title }}"
                        placeholder="Enter title" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-control js-ckeditor" rows="5">{{ $video->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="url" class="form-label">URL</label>
                    <input type="url" name="url" class="form-control" id="url" value="{{ $video->url }}"
                        placeholder="https://example.com" required>
                </div>

                <div class="mb-3"> {{ $video->image }}
                    <label for="image" class="form-label">Upload Image</label>
                    <input type="file" name="image" class="form-control" id="image" accept="image/*">
                    @if ($video->image)
                        @php
                            // use Illuminate\Support\Str;
                            $isUrl = Illuminate\Support\Str::startsWith($video->image, ['http://', 'https://']);
                        @endphp
                        <div class="mt-2">
                            <img src="{{ $isUrl ? $video->image : asset('storage/' . $video->image) }}" alt="Current Image"
                                class="img-thumbnail" width="150">
                        </div>
                    @endif
                </div>


                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('tgg-india.trainer.videos.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
