@extends('tgg-india.layouts.app')

@section('title', 'Feature Limits | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
        <h4 class="mb-3 trainer-heading">Feature Limits</h4>
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-2 w-100 w-md-auto">

                <form action="{{ route('tgg-india.trainer.feature-limits.setPrice') }}" method="POST"
                    class="d-flex align-items-center gap-2">
                    @csrf
                    <input type="number" title="This is the price associates will need to pay once they exceed their free limit." name="price" class="form-control" placeholder="Set Price" style="width: 120px;"
                    @if (!$featureLimits[0] || $featureLimits[0]->created_by !== Auth('web2')->id()) disabled @endif value="{{ $featureLimits[0]->price ?? '' }}">
                    <input type="hidden" name="created_by" value="{{ $featureLimits[0]->created_by ?? '' }}">
                    <button type="submit" title="This is the price associates will need to pay once they exceed their free limit." class="btn btn-primary create-button" @if (!$featureLimits[0] || $featureLimits[0]->created_by !== Auth('web2')->id()) disabled @endif>
                        Save
                    </button>
                </form>
               

            <a href="{{ route('tgg-india.trainer.feature-limits.create') }}" class="btn btn-primary create-button mt-2 mt-md-0">Create New</a>
        </div>
    </div>

    @include('tgg-india.layouts.includes.message')

    <div class="table-responsive">
        <table class="table table-striped table-bordered mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Feature</th>
                    <th>Free Limit</th>
                    <th>Created</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($featureLimits as $feature)
                    <tr>
                        <td>{{ ucfirst($feature->feature_key) }}</td>
                        <td>{{ $feature->free_limit }}</td>
                        <td>{{ $feature->created_at?->format('d M Y') }}</td>
                        <td>{{ $feature->price ?? 'N/A' }}</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center gap-1 flex-wrap">
                                <a href="{{ route('tgg-india.trainer.feature-limits.edit', $feature->id) }}"
                                    class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0 me-2"
                                    style="width: 28px; height: 28px;">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('tgg-india.trainer.feature-limits.destroy', $feature->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this feature?');">
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
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No features found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
