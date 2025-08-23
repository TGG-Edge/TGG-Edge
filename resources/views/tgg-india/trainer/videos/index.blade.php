@extends('tgg-india.layouts.app')

@section('title', 'Videos | TGG Meta | TGG India')

@section('content')
    <div class="admin-container">
        <!-- Create Button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-3 trainer-heading">Videos</h4>
            <div class="d-flex align-items-center gap-2">
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

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>URL</th>
                    <th>Image</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($videos as $index => $video)
                    <tr>
                        <td>{{ ++$index }}</td>
                        <td>{{ $video->title }}</td>
                        <td class="text-justify">
                            @php
                                $plainText = strip_tags($video->description);
                                $preview = strlen($plainText) > 120 ? substr($plainText, 0, 120) . '...' : $plainText;
                            @endphp

                            <!-- Preview (normal text, clickable, justified) -->
                            <span style="cursor: pointer; display: block; text-align: justify;"
                                data-bs-toggle="modal" data-bs-target="#descModal-{{ $video->id }}">
                                {{ $preview }}
                            </span>

                            <!-- Modal -->
                            <div class="modal fade" id="descModal-{{ $video->id }}" tabindex="-1" aria-labelledby="descModalLabel-{{ $video->id }}" aria-hidden="true">
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
                                    // Check if image is a full URL
                                    $isUrl = Str::startsWith($video->image, ['http://', 'https://']);
                                @endphp

                                <img src="{{ $isUrl ? $video->image : asset('storage/' . $video->image) }}"
                                    alt="Video Image" width="60" height="40"
                                    style="object-fit: cover; border-radius: 4px;">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>
                        <td class="align-middle">{{ $video->created_at->format('Y-m-d') }}</td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="{{ route('tgg-india.trainer.videos.edit', $video->id) }}"
                                    class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0 me-2"
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
                        <td colspan="5" class="text-center">No videos found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
