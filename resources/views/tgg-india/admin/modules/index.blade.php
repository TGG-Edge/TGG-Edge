@extends('tgg-india.layouts.app')

@section('title', 'Trainer Dashboard - TGG India')

@section('content')
<div class="admin-container">
    <!-- Create Button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-3 trainer-heading">Modules</h4>
        <a href="{{ route('tgg-india.admin.modules.create') }}" class="btn btn-primary create-button">
            <i class="bi bi-plus-lg"></i> Create
        </a>
    </div>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Assigned Users</th>
                 <th>Assigned Features</th>
                <th>Created At</th>
                <th class="text-center" width="120">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($modules as $index => $module)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $module->name }}</td>
                    <td>{{ $module->slug }}</td>
                    <td>
                        @if($module->users->count())
                            <ul class="mb-0 ps-3">
                                @foreach($module->users as $user)
                                    <li>{{ $user->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-muted">No users assigned</span>
                        @endif
                    </td>
                    <td>
                        @if($module->features->count())
                            <ul class="mb-0 ps-3">
                                @foreach($module->features as $feature)
                                    <li>{{ $feature->feature_name  }}</li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-muted">No features assigned</span>
                        @endif
                    </td>

                    <td>{{ $module->created_at->format('d M Y') }}</td>
                    <td class="text-center d-flex justify-content-center">
                        <!-- Edit button -->
                        <a href="{{ route('tgg-india.admin.modules.edit', $module) }}" 
                           class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0 me-2" 
                           style="width: 28px; height: 28px;position: relative; top: 2px;">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- Delete button -->
                        <form action="{{ route('tgg-india.admin.modules.destroy', $module) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this module?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0" 
                                    style="width: 28px; height: 28px;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No modules found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection