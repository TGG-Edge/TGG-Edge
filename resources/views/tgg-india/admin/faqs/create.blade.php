@extends('tgg-india.layouts.app')

@section('title', 'Create FAQ | TGG Meta | TGG India')

@section('content')
<div class="admin-container">

    <h4 class="mb-3 trainer-heading">Create FAQ</h4>

    @include('tgg-india.layouts.includes.message')

    <div class="card p-3 p-md-4 mb-4">

        <form action="{{ route('tgg-india.admin.faqs.store') }}" method="POST">
            @csrf

            @if(request()->has('parent_id'))
                <input type="hidden" name="parent_id" value="{{ request()->parent_id }}">
            @endif

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Question</label>
                <input type="text"
                       name="title"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Answer</label>
                <textarea name="description"
                          class="form-control js-ckeditor"
                          rows="5"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="is_active" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary save-button mt-2">
                Save
            </button>

        </form>

    </div>
</div>
@endsection
