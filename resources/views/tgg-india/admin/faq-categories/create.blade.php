@extends('tgg-india.layouts.app')

@section('title','Create FAQ Category')

@section('content')
<div class="admin-container">

    <h4 class="trainer-heading mb-3">Create FAQ Category</h4>

    @include('tgg-india.layouts.includes.message')

    <div class="card p-4">

        <form action="{{ route('tgg-india.admin.faq-categories.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Parent Category</label>
                <select name="parent_id" class="form-control">
                    <option value="">-- Main Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="is_active" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="0">
            </div>

            <button class="btn btn-primary">
                Save
            </button>

        </form>

    </div>

</div>
@endsection
