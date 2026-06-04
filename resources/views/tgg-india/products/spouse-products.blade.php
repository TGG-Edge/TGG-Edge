@extends('tgg-india.layouts.app')

@section('title', 'Spouse Products')

@section('content')

<div class="admin-container">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4 class="trainer-heading">
            Spouse Products
        </h4>

        <a href="{{ url()->previous() }}"
           class="btn btn-secondary">

            Back

        </a>

    </div>

    @include('tgg-india.layouts.includes.message')

    <div class="table-responsive">

        <table class="table table-bordered table-striped">

            <thead class="table-dark">

                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Amount</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Active</th>
                </tr>

            </thead>

            <tbody>

                @forelse($products as $product)

                <tr>

                    <td>

                        @if($product->image)

                            <img src="{{ asset('storage/'.$product->image) }}"
                                 width="60"
                                 height="60"
                                 style="object-fit:cover; border-radius:6px;">

                        @else

                            N/A

                        @endif

                    </td>

                    <td>{{ $product->title }}</td>

                    <td>₹{{ $product->amount }}</td>

                    <td>{{ $product->stock }}</td>

                    <td>
                        {!! statusWithColor($product->status) !!}
                    </td>

                    <td>

                        @if($product->is_active)
                            Active
                        @else
                            Inactive
                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="text-center">
                        No products found.
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-3">

        {{ $products->links() }}

    </div>

</div>

@endsection