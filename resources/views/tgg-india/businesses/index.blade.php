@extends('tgg-india.layouts.app')

@section('title', 'Business Dashboard | TGG Meta | TGG India')

@section('content')
<div class="admin-container">

    <!-- Header -->
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-3">

        <h4 class="mb-3 trainer-heading">Businesses</h4>

            

        <div class="d-flex align-items-center justify-content-end gap-2 w-100 w-lg-auto mt-2 mt-lg-0">

            <a href="{{ route('tgg-india.businesses.create', ['role' => auth('web2')->user()->role_key]) }}"
               class="btn btn-primary assignment-button">

                <i class="bi bi-plus-lg"></i> New Business
            </a>

        </div>

    </div>

    @include('tgg-india.layouts.includes.message')  

    <!-- Table -->
    <div class="table-responsive">

        <table class="table table-striped table-bordered align-middle">

            <thead class="table-dark">
                <tr>
                    <th>Logo</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Owner</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($businesses as $business)

                <tr>

                    <td width="80">

                        @if($business->image)
                            <img src="{{ asset('storage/'.$business->image) }}"
                                 width="50"
                                 height="50"
                                 style="object-fit:cover; border-radius:8px;">
                        @else
                            N/A
                        @endif

                    </td>

                    <td>{{ $business->title }}</td>

                    <td>{{ $business->code ?? 'N/A' }}</td>

                    <td>{{ $business->owner?->name }}</td>

                    <td>{{ $business->phone ?? 'N/A' }}</td>

                    <td>{{ $business->email ?? 'N/A' }}</td>

                    <td>
                        {!! statusWithColor($business->status) !!}
                    </td>

                    <td>

                        <div class="d-flex justify-content-center align-items-center gap-2 flex-wrap">

                            <a href="{{ route('tgg-india.businesses.show', [$business->id, 'role' => auth('web2')->user()->role_key]) }}"
                               class="btn btn-warning btn-sm d-flex align-items-center justify-content-center p-0"
                               style="width: 28px; height: 28px;">

                                <i class="fas fa-eye"></i>
                            </a>

                            <!-- Edit -->
                            <a href="{{ route('tgg-india.businesses.edit', [$business->id, 'role' => auth('web2')->user()->role_key]) }}"
                               class="btn btn-primary btn-sm d-flex align-items-center justify-content-center p-0"
                               style="width: 28px; height: 28px;">

                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- Delete -->
                            <form action="{{ route('tgg-india.businesses.destroy', [ $business->id , 'role' => auth('web2')->user()->role_key]) }}"
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

                </tr>

                @empty

                <tr>
                    <td colspan="8" class="text-center">
                        No businesses found.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $businesses->links() }}
    </div>

</div>
@endsection