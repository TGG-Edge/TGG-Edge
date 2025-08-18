<link rel="stylesheet" href="{{ asset('assets/bootstrap-icons/bootstrap-icons.css') }}">

@extends('tgg-india.layouts.app')

@section('title', 'Trainer Dashboard - TGG India')

@section('content')
<div class="admin-container">
    <h4 class="mb-3 trainer-heading">links</h4>

    <!-- Create Button -->
    <div class="d-flex justify-content-end mb-3" style="margin-right: 20px;">
        <a href="{{ route('tgg-india.trainer.links.create') }}" class="btn btn-primary">
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
            @forelse ($links as $link)
                <tr>
                    <td>{{ $link->id }}</td>
                    <td>{{ $link->title }}</td>
                    <td>{!! $link->description !!}</td>
                    <td>{{ $link->created_at->format('Y-m-d') }}</td>
                    <td class="d-flex align-items-center justify-content-center">
                        <a href="{{ route('tgg-india.trainer.links.edit', $link->id) }}" 
                           class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0 me-2" 
                           style="width: 28px; height: 28px;">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                        <form action="{{ route('tgg-india.trainer.links.destroy', $link->id) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this link?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0" 
                                    style="width: 28px; height: 28px;">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No links found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
