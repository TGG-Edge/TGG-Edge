@extends('tgg-india.layouts.app')
@include('tgg-india.layouts.includes.message')

@section('title', 'Index Chapters | TGG Meta | TGG India')

@section('content')
    <div class="admin-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-3 trainer-heading">Modules</h4>
            @if ($is_exceeded)
            <div>
                <button class="btn btn-primary create-button" disabled>
                     <i class="bi bi-plus-lg"></i> Create
                </button>
                <button class="btn btn-warning" >
                    <i class="bi bi-lock"></i> Upgrade to Create More
                </button>
            </div>
            @else
            <a href="{{ route('tgg-india.trainer.chapters.create', ['section_id' => request()->section_id]) }}"
                class="btn btn-primary create-button">
                <i class="bi bi-plus-lg"></i> Create
            </a>
            @endif
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
                @forelse ($chapters as $index =>$chapter)
                    <tr>
                        <td>{{ ++$index }}</td>
                        <td>{{ $chapter->title }}</td>
                        <td>{!! $chapter->content ?? 'N/A' !!}</td>

                        <td>{{ $chapter->created_at->format('Y-m-d') }}</td>
                        <td class="d-flex align-items-center justify-content-center">
                            <a href="{{ route('tgg-india.trainer.chapters.edit', $chapter->id) }}"
                                class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0 me-2"
                                style="width: 28px; height: 28px;">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('tgg-india.trainer.chapters.destroy', $chapter->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this chapter?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0"
                                    style="width: 28px; height: 28px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No chapters found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
