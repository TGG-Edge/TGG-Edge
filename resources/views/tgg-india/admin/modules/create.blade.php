@extends('tgg-india.layouts.app')

@section('title', 'Create Modules | TGG Meta | TGG India')

@section('content')
    <div class="admin-container">
        <h4 class="mb-3 trainer-heading">Create New Module</h4>
        @include('tgg-india.layouts.includes.message')

        <div class="card p-3 mb-4">
            <form action="{{ route('tgg-india.admin.modules.store') }}" method="POST">
                @csrf
                <label>Name:</label>
                <input type="text" name="name" class="form-control">

                <label>Assign Users:</label>
                <select name="users[]" multiple placeholder="Select Users">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>

                <label for="features">Select Features:</label>
                <select name="features[]" id="features" multiple placeholder="Select Features">
                    @foreach ($features as $key => $name)
                        <option value="{{ $key }}">{{ $name }}</option>
                    @endforeach
                </select>
        </div>

        <button type="submit" class="btn btn-primary mt-2 save-button">Save</button>
        </form>

    </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Apply Choices.js to "Assign Users"
            new Choices('select[name="users[]"]', {
                removeItemButton: true,
                placeholderValue: 'Select Users',
                searchEnabled: true,
            });

            // Apply Choices.js to "Features"
            new Choices('#features', {
                removeItemButton: true,
                placeholderValue: 'Select Features',
                searchEnabled: true,
            });
        });
    </script>
@endpush
