@extends('tgg-india.layouts.app')

@section('title', 'Links | TGG Meta | TGG India')

@section('content')
    <div class="admin-container">
        <!-- Create Button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-3 trainer-heading">links</h4>
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
                    <a href="{{ route('tgg-india.trainer.links.create') }}" class="btn btn-primary create-button">
                        <i class="bi bi-plus-lg"></i> Create
                    </a>
                    <a href="{{ route('tgg-india.trainer.links.aigen') }}" 
                        class="btn btn-primary aigen-button">
                            <i class="bi bi-magic"></i> AIGen
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
                    <th>Url</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($links as $index => $link)
                    <tr>
                        <td>{{ ++$index }}</td>
                        <td>{{ $link->title }}</td>
                        <td>{!! $link->description !!}</td>
                        <td>{{ $link->url }}</td>

                        <td>{{ $link->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="{{ route('tgg-india.trainer.links.edit', $link->id) }}"
                                    class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0 me-2"
                                    style="width: 28px; height: 28px;">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('tgg-india.trainer.links.destroy', $link->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this link?');">
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
                        <td colspan="5" class="text-center">No links found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $links->links() }}
    </div>
@endsection
