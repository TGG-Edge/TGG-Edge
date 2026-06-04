@extends('tgg-india.layouts.app')

@section('title', 'Products | TGG India')

@section('content')

<div class="admin-container">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4 class="trainer-heading">
            Products
        </h4>

        <a href="{{ route('tgg-india.products.create',['role' => auth('web2')->user()->role_key]) }}"
           class="btn btn-primary">

            <i class="bi bi-plus-lg"></i> Add Product
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
                    <th width="140">Action</th>
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

                    <td>

                        <div class="d-flex gap-2">

                            <a href="javascript:void(0)"
                            onclick="copyProductLink('{{ route('tgg-india.products.spouse',[ 'spouse' => $product->user_id]) }}')"
                            class="btn btn-info btn-sm">

                                <i class="fas fa-copy"></i>

                            </a>


                            <a href="{{ route('tgg-india.products.edit',[$product->id,'role' => auth('web2')->user()->role_key]) }}"
                               class="btn btn-primary btn-sm">

                                <i class="fas fa-edit"></i>

                            </a>

                            <form action="{{ route('tgg-india.products.destroy',[$product->id,'role' => auth('web2')->user()->role_key]) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="7" class="text-center">
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
@push('scripts')
<script>

    function copyProductLink(link)
    {
        navigator.clipboard.writeText(link);

        alert('Link copied successfully!');
    }

</script>
@endpush