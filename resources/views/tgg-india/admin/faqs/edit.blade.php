@extends('tgg-india.layouts.app')

@section('title', 'Edit FAQ | TGG Meta | TGG India')

@section('content')
<div class="admin-container">

    <h4 class="mb-3 trainer-heading">Edit FAQ</h4>

    @include('tgg-india.layouts.includes.message')

    <div class="card p-3 p-md-4 mb-4">

        <form action="{{ route('tgg-india.admin.faqs.update', $faq->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Parent ID (For Nested FAQ) --}}
            @if($faq->parent_id)
                <input type="hidden" name="parent_id" value="{{ $faq->parent_id }}">
            @endif

            {{-- Category --}}
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $faq->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Question --}}
            <div class="mb-3">
                <label class="form-label">Question</label>
                <input type="text"
                       name="title"
                       class="form-control"
                       value="{{ old('title', $faq->title) }}"
                       required>
            </div>

            {{-- Answer --}}
            <div class="mb-3">
                <label class="form-label">Answer</label>
                <textarea name="description"
                          class="form-control js-ckeditor"
                          rows="5">{{ old('description', $faq->description) }}</textarea>
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="is_active" class="form-control">
                    <option value="1" {{ $faq->is_active == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $faq->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary save-button mt-2">
                Update
            </button>

        </form>

    </div>
</div>
@endsection
