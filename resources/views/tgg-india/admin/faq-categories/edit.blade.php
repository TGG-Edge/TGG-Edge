@extends('tgg-india.layouts.app')

@section('title','Edit FAQ Category')

@section('content')
<div class="admin-container">

    <h4 class="trainer-heading mb-3">Edit FAQ Category</h4>

    <div class="card p-4">

        <form action="{{ route('tgg-india.admin.faq-categories.update',$faq_category->id) }}"
              method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Parent Category</label>
                <select name="parent_id" class="form-control">
                    <option value="">-- Main Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $faq_category->parent_id == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Title</label>
                <input type="text"
                       name="title"
                       class="form-control"
                       value="{{ $faq_category->title }}"
                       required>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description"
                          class="form-control">{{ $faq_category->description }}</textarea>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="is_active" class="form-control">
                    <option value="1" {{ $faq_category->is_active ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$faq_category->is_active ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Sort Order</label>
                <input type="number"
                       name="sort_order"
                       class="form-control"
                       value="{{ $faq_category->sort_order }}">
            </div>

            <button class="btn btn-primary">
                Update
            </button>

        </form>

    </div>

</div>
@endsection
