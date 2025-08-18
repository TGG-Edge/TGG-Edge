<link rel="stylesheet" href="{{ asset('assets/bootstrap-icons/bootstrap-icons.css') }}">

@extends('tgg-india.layouts.app')

@section('title', 'Videos | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <!-- Create Button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-3 trainer-heading">Videos</h4>
        <a href="{{ route('tgg-india.trainer.videos.create') }}" class="btn btn-primary create-button">
            <i class="bi bi-plus-lg"></i> Create
        </a>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($videos as $video)
                <tr>
                    <td>{{ $video->id }}</td>
                    <td>{{ $video->title }}</td>
                    <td>{!! $video->description !!}</td>
                    <td>{{ $video->created_at->format('Y-m-d') }}</td>
                    <td class="d-flex align-items-center justify-content-center">
                        <a href="{{ route('tgg-india.trainer.videos.edit', $video->id) }}" 
                           class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0 me-2" 
                           style="width: 28px; height: 28px;">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('tgg-india.trainer.videos.destroy', $video->id) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this video?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0" 
                                    style="width: 28px; height: 28px;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
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
