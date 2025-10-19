@extends('tgg-india.layouts.app')

@section('title', 'Videos | TGG Meta | TGG India')

@section('content')
<div class="admin-container container-fluid py-3">

    <!-- Header & Create Buttons -->
    <div class="row mb-3 align-items-center">
        <div class="col-12 col-md-6 mb-2 mb-md-0">
            <h4 class="trainer-heading mb-0">Videos</h4>
        </div>
        <div class="col-12 col-md-6 d-flex flex-wrap justify-content-md-end gap-2">
            @if ($is_exceeded)
                <button class="btn btn-primary create-button" disabled>
                    <i class="bi bi-plus-lg"></i> Create
                </button>
                <button class="btn btn-warning">
                    <i class="bi bi-lock"></i> Upgrade to Create More
                </button>
                <button type="button" class="btn btn-primary aigen-button" disabled>
                    <i class="bi bi-plus-lg"></i> AIGen
                </button>
            @else
                <a href="{{ route('tgg-india.trainer.videos.create') }}" class="btn btn-primary create-button">
                    <i class="bi bi-plus-lg"></i> Create
                </a>
                <a href="{{ route('tgg-india.trainer.videos.aigen') }}" class="btn btn-primary aigen-button">
                    <i class="bi bi-plus-lg"></i> AIGen
                </a>
            @endif
        </div>
    </div>

    @include('tgg-india.layouts.includes.message')

    <!-- Responsive Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                    <th scope="col" style="min-width: 200px;">Description</th>
                    <th scope="col">URL</th>
                    <th scope="col">Image</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($videos as $index => $video)
                    <tr>
                        <td>{{ ++$index }}</td>
                        <td>{{ $video->title }}</td>
                        <td class="text-start text-wrap">
                            @php
                                $plainText = strip_tags($video->description);
                                $preview = strlen($plainText) > 120 ? substr($plainText, 0, 120) . '...' : $plainText;
                            @endphp
                            <span style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#descModal-{{ $video->id }}">
                                {{ $preview }}
                            </span>

                            <!-- Modal -->
                            <div class="modal fade" id="descModal-{{ $video->id }}" tabindex="-1"
                                aria-labelledby="descModalLabel-{{ $video->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="descModalLabel-{{ $video->id }}">{{ $video->title }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-justify">
                                            {!! $video->description !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if ($video->url && $video->url !== '#')
                                {{ $video->url }}
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            @if ($video->image)
                                @php
                                    $imagePath = $video->image;
                                    $isUrl = Str::startsWith($imagePath, ['http://', 'https://']);
                                    $imageSrc = $isUrl ? $imagePath : (Storage::disk('public')->exists($imagePath) ? asset('storage/' . $imagePath) : (file_exists(public_path($imagePath)) ? asset($imagePath) : asset('images/default-thumbnail.jpg')));
                                @endphp
                                <img src="{{ $imageSrc }}" alt="Video Image"
                                     style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>
                        <td>{{ $video->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                <a href="{{ route('tgg-india.trainer.videos.edit', $video->id) }}"
                                    class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0"
                                    style="width: 28px; height: 28px;">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('tgg-india.trainer.videos.destroy', $video->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this video?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0"
                                        style="width: 28px; height: 28px;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No videos found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $videos->links() }}
    </div>

</div>
@endsection
