@extends('tgg-india.layouts.app')

@section('title', 'Campaigns')

@section('content')
<div class="admin-container">

    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="trainer-heading">Campaigns</h4>
        </div>
        <div class="col-md-6 text-end">
            @php
              $left_campaigns = \App\Models\Campaign::where('created_at', '>=', \Carbon\Carbon::today())->count();
            @endphp

            <span class="btn btn-info me-2 text-white">
              Used  {{ $left_campaigns }}  out of 200
            </span>



            <a href="{{ route('tgg-india.campaigns.create', request()->route('role')) }}"
               class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> New Campaign
            </a>
        </div>
    </div>

    @include('tgg-india.layouts.includes.message')

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Template</th>
                <th>User</th>
                <th>Status</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($campaigns as $index => $campaign)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $campaign->template->name ?? 'N/A' }}</td>
                    <td>{{ $campaign->user->name ?? 'N/A' }}</td>
                    <td>{{ ucfirst($campaign->status) }}</td>
                    <td>{{ $campaign->created_at }}</td>
                    <td>
                    <a href="{{ route('tgg-india.campaigns.show', [request()->route('role'), $campaign->id]) }}"
                       class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                    <form method="GET"
                              action="{{ route('tgg-india.campaigns.delete',$campaign->id) }}"
                              style="display:inline">
                            <button class="btn btn-danger btn-sm" style="width:35px;height:35px;">
                                <i class="fas fa-trash"></i>
                            </button>
                    </form>
                </td>

                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $campaigns->links() }}

</div>
@endsection
