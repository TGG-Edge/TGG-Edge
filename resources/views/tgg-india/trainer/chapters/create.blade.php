
@extends('tgg-india.layouts.app')

@section('title', 'Create Trainer Project - TGG India')

@section('content')
    <div class="admin-container">
        <h4 class="mb-3 trainer-heading">Create New chapter</h4>

        <div class="card p-3 mb-4">
            <form action="{{ route('tgg-india.trainer.chapters.store') }}" method="POST">
                @csrf
                <input type="hidden" name="section_id" value="{{request()->section_id}}">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter title">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">content</label>
                    <textarea id="description" name="content" class="form-control js-ckeditor" rows="5"></textarea>
                </div>
                <button type="submit" class="btn btn-primary save-button">Save</button>
            </form>
        </div>
    </div>

    <!-- CKEditor 5 Script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
