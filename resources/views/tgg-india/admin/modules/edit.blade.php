@extends('tgg-india.layouts.app')

@section('title', 'Edit Module | TGG Meta | TGG India')

@section('content')
    <div class="admin-container">
        <h4 class="mb-3 trainer-heading">Edit Module</h4>
        @include('tgg-india.layouts.includes.message')

        <div class="card p-3 mb-4">
            <form action="{{ route('tgg-india.admin.modules.update', $module->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Module Name -->
                <label>Name:</label>
                <input type="text" name="name" value="{{ old('name', $module->name) }}" class="form-control">

                <label class="mt-2">Created By:</label>
                @php
                    $module_instance = $module->moduleInstances->first();
                @endphp
                <select name="user_id" placeholder="Select User who create this module" class="form-control mb-2">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @if($module_instance->user_id == $user->id) {{'selected'}} @endif>{{ $user->name }}</option>
                    @endforeach
                </select>

                <!-- Assign Users -->
                @php
                $moduleInstanceId = \App\Models\ModuleInstance::where('module_id', $module->id)
                            ->orderBy('id')
                            ->value('id');
                $assigns = \App\Models\ModuleInstanceAssign::whereJsonContains(
                    'module_instance_ids',
                    $moduleInstanceId
                )->get();
                $userIds = $assigns->pluck('user_id')->unique()->values();
                $assigned_users = \App\Models\UserSecondary::whereIn('id', $userIds)->get();
                @endphp
                <label>Assign Users:</label>
                <select name="users[]" multiple id="users-select">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                            {{ in_array($user->id, $assigned_users->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $user->name. ' - '. $user->role_name }}
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
