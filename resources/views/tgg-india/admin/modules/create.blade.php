@extends('tgg-india.layouts.app')

@section('title', 'Create Trainer Project - TGG India')

@section('content')
    <div class="admin-container">
        <h4 class="mb-3 trainer-heading">Create New Module</h4>

        <div class="card p-3 mb-4">
            <form action="{{ route('tgg-india.admin.modules.store') }}" method="POST">
                @csrf
                <label>Name:</label>
                <input type="text" name="name" class="form-control">

                <label>Assign Users:</label>
                <select name="users[]" class="form-control" multiple>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>

                <!-- Features Multi-Select -->
    <div>
        <label for="features">Select Features:</label>
        <select name="features[]" id="features" multiple required>
            @foreach($features as $key => $name)
                <option value="{{ $key }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>
    
                <button type="submit" class="btn btn-primary mt-2">Save</button>
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
