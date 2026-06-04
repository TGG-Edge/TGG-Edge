@extends('tgg-india.layouts.app')

@section('title', 'Show Project | TGG Meta | TGG India')

@section('content')

<div class="container mt-4">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="card p-4 shadow-sm mb-4">

                <h3 class="mb-3">
                    {{ $project->name }}
                </h3>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <strong>Business:</strong><br>
                        {{ $project->business?->name ?? 'N/A' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Owner:</strong><br>
                        {{ $project->owner?->name }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Amount:</strong><br>
                        {{ $project->amount ?? '0' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Status:</strong><br>
                        {{ ucfirst($project->status) }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Start Date:</strong><br>
                        {{ $project->start_date ?? 'N/A' }}
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>End Date:</strong><br>
                        {{ $project->end_date ?? 'N/A' }}
                    </div>

                </div>

                <hr>

                <h5>
                    Description
                </h5>

                <div class="mb-4">
                    {!! $project->description !!}
                </div>

                <hr>

                <h5 class="mb-3">
                    Project Members
                </h5>

                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead class="table-dark">

                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role Type</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($project->members as $member)

                            <tr>

                                <td>
                                    {{ $member->user?->name }}
                                </td>

                                <td>
                                    {{ $member->user?->email }}
                                </td>

                                <td>
                                    {{ ucfirst($member->role_type) }}
                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="3" class="text-center">
                                    No members assigned.
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <a href="{{ url()->previous() }}"
                   class="btn btn-secondary mt-3">

                    Back

                </a>

            </div>

        </div>

    </div>

</div>

@endsection