@extends('tgg-india.layouts.app')

@section('title', 'Edit Module | TGG Meta | TGG India')

@section('content')
    <div class="admin-container">
        <h4 class="mb-3 trainer-heading">Edit Module</h4>

        <div class="card p-3 mb-4">
            <form action="{{ route('tgg-india.admin.modules.update', $module->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Module Name -->
                <label>Name:</label>
                <input type="text" name="name" value="{{ old('name', $module->name) }}" class="form-control">

                <!-- Assign Users -->
                <label>Assign Users:</label>
                <select name="users[]" multiple id="users-select">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                            {{ in_array($user->id, $module->users->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Features -->
                <label for="features">Select Features:</label>
                <select name="features[]" id="features" multiple>
                    @foreach ($features as $key => $name)
                        <option value="{{ $key }}"
                            {{ in_array($key, $module->features->pluck('feature_key')->toArray()) ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
        </div>

        <button type="submit" class="btn btn-primary mt-2 save-button">Update</button>
        </form>

    </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Apply Choices.js to "Assign Users"
            new Choices('#users-select', {
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
