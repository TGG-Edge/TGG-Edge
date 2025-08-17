
<link rel="stylesheet" href="{{ asset('assets/bootstrap-icons/bootstrap-icons.css') }}">


@extends('tgg-india.layouts.app')

@section('title', 'Trainer Dashboard - TGG India')


@section('content')
<div class="admin-container">
    <h4 class="mb-3 trainer-heading">Modules</h4>
    <!-- Create Button -->
     <div class="d-flex justify-content-end mb-3" style="margin-right: 20px;">
        <a href="{{ route('tgg-india.admin.modules.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Create
        </a>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Assigned Users</th>
                 <th>Assigned Features</th>
                <th>Created At</th>
                <th width="180">Actions</th>
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
                    <td>
                        <a href="{{ route('tgg-india.admin.modules.edit', $module) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('tgg-india.admin.modules.destroy', $module) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this module?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
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
