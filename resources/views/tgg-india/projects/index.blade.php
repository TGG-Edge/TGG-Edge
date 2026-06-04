@extends('tgg-india.layouts.app')

@section('title', 'Projects Dashboard | TGG Meta | TGG India')

@section('content')

<div class="admin-container">

    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-3">

        <h4 class="mb-3 trainer-heading">
            Projects
        </h4>

        @include('tgg-india.layouts.includes.message')

        @if(auth('web2')->user()->user_role != 6)
        <a href="{{ route('tgg-india.projects.create',['role' => auth('web2')->user()->role_key]) }}"
           class="btn btn-primary assignment-button">

            <i class="bi bi-plus-lg"></i> New Project
        </a>
        @endif

    </div>

    <div class="table-responsive">

        <table class="table table-striped table-bordered align-middle">

            <thead class="table-dark">

                <tr>
                    <th>Name</th>
                    <th>Business</th>
                    <th>Owner</th>
                    <th>Amount</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Status</th>
                    <th>Members</th>
                    @if(auth('web2')->user()->user_role != 6)
                    <th width="120">Actions</th>
                    @endif
                </tr>

            </thead>

            <tbody>

                @forelse($projects as $project)

                <tr>

                    <td>{{ $project->title }}</td>

                    <td>{{ $project->business?->title ?? 'N/A' }}</td>

                    <td>{{ $project->owner?->name }}</td>

                    <td>{{ $project->amount ?? '0' }}</td>

                    <td>{{ $project->start_date ?? 'N/A' }}</td>

                    <td>{{ $project->end_date ?? 'N/A' }}</td>

                    <td>
                        {!! statusWithColor($project->status) !!}
                    </td>

                    <td>
                        {{ $project->members->count() }}
                    </td>
                    @if(auth('web2')->user()->user_role != 6)
                    <td>

                        <div class="d-flex justify-content-center align-items-center gap-2 flex-wrap">

                            <a href="{{ route('tgg-india.projects.show',[ $project->id, 'role' => auth('web2')->user()->role_key]) }}"
                               class="btn btn-warning btn-sm d-flex align-items-center justify-content-center p-0"
                               style="width: 28px; height: 28px;">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('tgg-india.projects.edit',[ $project->id, 'role' => auth('web2')->user()->role_key]) }}"
                               class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0"
                               style="width: 28px; height: 28px;">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('tgg-india.projects.destroy',[$project->id,'role' => auth('web2')->user()->role_key]) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0"
                                        style="width: 28px; height: 28px;">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </form>

                        </div>

                    </td>
                    @endif
                </tr>

                @empty

                <tr>
                    <td colspan="9" class="text-center">
                        No projects found.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-3">
        {{ $projects->links() }}
    </div>

</div>

@endsection