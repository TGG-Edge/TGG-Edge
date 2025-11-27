@extends('tgg-india.layouts.app')

@section('title', 'Index Literature | TGG Meta | TGG India')

@section('content')
<div class="admin-container container-fluid py-3">

    <!-- Create Button (Responsive Alignment) -->
    <div class="row mb-3">
        <div class="col-12 d-flex flex-wrap justify-content-between justify-content-md-end align-items-center gap-2 px-3">
            <a href="{{ route('tgg-india.trainer.literatures.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Create
            </a>
            <button type="button" class="btn btn-primary aigen-button">
                <i class="bi bi-plus-lg"></i> AIGen
            </button>
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
                    <th scope="col">Created At</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($literatures as $literature)
                    <tr>
                        <td>{{ $literature->id }}</td>
                        <td>{{ $literature->title }}</td>
                        <td class="text-start text-wrap">
                            @php
                                $plainText = strip_tags($literature->description);
                                $preview = strlen($plainText) > 120 ? substr($plainText, 0, 120) . '...' : $plainText;
                            @endphp

                            <!-- Preview text -->
                            <span style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#descModal-{{ $literature->id }}">
                                {{ $preview }}
                            </span>

                            <!-- Modal -->
                            <div class="modal fade" id="descModal-{{ $literature->id }}" tabindex="-1"
                                aria-labelledby="descModalLabel-{{ $literature->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="descModalLabel-{{ $literature->id }}">{{ $literature->title }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-justify">
                                            {!! $literature->description !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>{{ $literature->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                <a href="{{ route('tgg-india.trainer.literatures.edit', $literature->id) }}"
                                    class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0"
                                    style="width: 30px; height: 30px;">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('tgg-india.trainer.literatures.destroy', $literature->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this literature?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0"
                                        style="width: 30px; height: 30px;">
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
</div>
@endsection
