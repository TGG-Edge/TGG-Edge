@extends('tgg-india.layouts.app')

@section('title', 'Templates | TGG Meta | TGG India')

@section('content')
<div class="admin-container">

    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="trainer-heading">Templates</h4>
        </div>

        <div class="col-md-6 text-end">
            <a href="{{ route('tgg-india.templates.create',[$user->role_key]) }}"
               class="btn btn-primary assignment-button">
                <i class="bi bi-plus-lg"></i> New Template
            </a>
        </div>
    </div>

    @include('tgg-india.layouts.includes.message')

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($templates as $template)
                <tr>
                    <td>{{ $template->name }}</td>
                    <td>{{ ucfirst($template->type) }}</td>
                    <td>{!! statusWithColor($template->status) !!}</td>
                    <td>
                        <a href="{{ route('tgg-india.templates.show',[$template->id, $user->role_key]) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{ route('tgg-india.templates.edit',[$template->id, $user->role_key]) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form method="GET"
                              action="{{ route('tgg-india.templates.destroy', $template->id) }}"
                              style="display:inline">
                            <button class="btn btn-danger btn-sm" style="width:33px;height:33px;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    {{ $templates->links() }}

</div>
@endsection
