@extends('tgg-india.layouts.app')
@include('tgg-india.layouts.includes.message')

@section('title', 'Index Literature | TGG Meta | TGG India')

@section('content')
<div class="admin-container">

    <!-- Create Button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-3 trainer-heading">Trainer Dashboard</h4>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('tgg-india.trainer.literatures.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Create
            </a>
            <button type="button" class="btn btn-primary create-button">
                    <i class="bi bi-plus-lg"></i> AI Generation
            </button>
        <div>
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
            @forelse ($literatures as $literature)
                <tr>
                    <td>{{ $literature->id }}</td>
                    <td>{{ $literature->title }}</td>
                    <td>{!! $literature->description !!}</td>
                    <td>{{ $literature->created_at->format('Y-m-d') }}</td>
                    <td>
                         <div class="d-flex align-items-center justify-content-center">
                            <a href="{{ route('tgg-india.trainer.literatures.edit', $literature->id) }}" 
                                class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0 me-2" 
                                style="width: 28px; height: 28px;">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('tgg-india.trainer.literatures.destroy', $literature->id) }}" method="POST" 
                                onsubmit="return confirm('Are you sure you want to delete this literature?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0" 
                                        style="width: 28px; height: 28px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>


                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No literatures found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
