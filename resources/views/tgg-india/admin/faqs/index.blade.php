@extends('tgg-india.layouts.app')

@section('title', 'FAQ Dashboard | TGG Meta | TGG India')

@section('content')
<div class="admin-container">

    <!-- Header -->
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-3">

        <h4 class="mb-3 trainer-heading">FAQs</h4>

       

        <div class="d-flex align-items-center justify-content-end gap-2 w-100 w-lg-auto mt-2 mt-lg-0">

            @if(request()->has('parent_id'))
                <a href="{{ route('tgg-india.admin.faqs.create', ['parent_id' => request()->parent_id]) }}"
                   class="btn btn-primary assignment-button">
                    <i class="bi bi-plus-lg"></i> New FAQ
                </a>
            @else
                <a href="{{ route('tgg-india.admin.faqs.create') }}"
                   class="btn btn-primary assignment-button">
                    <i class="bi bi-plus-lg"></i> New FAQ
                </a>
            @endif

        </div>
    </div>
     @include('tgg-india.layouts.includes.message')
    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Question</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Childs</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($faqs as $faq)
                <tr>
                    <td>{{ $faq->title }}</td>
                    <td>{{ $faq->category?->title ?? '-' }}</td>

                    <td>
                        {!! $faq->is_active
                            ? '<span class="badge bg-success">Active</span>'
                            : '<span class="badge bg-danger">Inactive</span>' !!}
                    </td>

                    <td>{{ $faq->creator?->name ?? '-' }}</td>

                    <td>
                        <a href="{{ route('tgg-india.admin.faqs.index', ['parent_id' => $faq->id]) }}">
                            {{ $faq->children ? $faq->children->count() : 0 }}
                        </a>
                    </td>

                    <td class="text-center">
                        <div class="d-flex justify-content-center align-items-center gap-2 flex-wrap">

                            <!-- View -->
                            <a href="{{ route('tgg-india.admin.faqs.show', $faq->id) }}"
                               class="btn btn-info btn-sm d-flex align-items-center justify-content-center p-0"
                               style="width:28px;height:28px;">
                                <i class="fas fa-eye"></i>
                            </a>

                            <!-- Edit -->
                            <a href="{{ route('tgg-india.admin.faqs.edit', $faq->id) }}"
                               class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0"
                               style="width:28px;height:28px;">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- Delete -->
                            <form action="{{ route('tgg-india.admin.faqs.destroy', $faq->id) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0"
                                        style="width:28px;height:28px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $faqs->links() }}
    </div>

</div>
@endsection
