@extends('tgg-india.layouts.app')
@section('title', 'Literature | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-3 trainer-heading">Sections</h4>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('tgg-india.trainer.sections.create') }}" class="btn btn-primary create-button">
                <i class="bi bi-plus-lg"></i> Create
            </a>
            {{-- <button type="button" class="btn btn-primary aigen-button">
                <i class="bi bi-plus-lg"></i> AIGen
            </button> --}}
        </div>
    </div>

    @include('tgg-india.layouts.includes.message')


    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Chapters</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sections as $index => $section)
                <tr>
                    <td>{{ ++$index}}</td>
                    <td>{{ $section->title }}</td>
                    <td> <a href="{{ route('tgg-india.trainer.chapters.index',['section_id' => $section->id]) }}">  {{ $section->chapters ? $section->chapters->count() : 0 }}</a></td>
                    <td>{{ $section->created_at->format('Y-m-d') }}</td>
                    <td>
                        <div class="d-flex align-items-center justify-content-center">
                        <a href="{{ route('tgg-india.trainer.sections.edit', $section->id) }}" 
                            class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0 me-2" 
                            style="width: 28px; height: 28px;">
                                <i class="fas fa-edit"></i>
                            </a>

                        <form action="{{ route('tgg-india.trainer.sections.destroy', $section->id) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this section?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0" 
                                    style="width: 28px; height: 28px;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No sections found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $sections->links() }}
</div>
@endsection
