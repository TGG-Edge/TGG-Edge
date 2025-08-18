
@extends('tgg-india.layouts.app')

@section('title', 'Create Literature | TGG Meta | TGG India')

@section('content')
    <div class="admin-container">
        <h4 class="mb-3 trainer-heading">Create New section</h4>

        <div class="card p-3 mb-4">
            <form action="{{ route('tgg-india.trainer.sections.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter title">
                </div>
                <!-- <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-control js-ckeditor" rows="5"></textarea>
                </div> -->
                <button type="submit" class="btn btn-primary save-button">Save</button>
            </form>
        </div>
    </div>

    <!-- CKEditor 5 Script -->
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script> -->
@endsection
