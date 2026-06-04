@extends('tgg-india.layouts.app')

@section('title', 'Edit Product')

@section('content')

<div class="admin-container">

    <h4 class="trainer-heading mb-3">
        Edit Product
    </h4>

    @include('tgg-india.layouts.includes.message')

    <div class="card p-4">

        <form action="{{ route('tgg-india.products.update',[$product->id,'role' => auth('web2')->user()->role_key]) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Product Title
                    </label>

                    <input type="text"
                           name="title"
                           value="{{ $product->title }}"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Amount
                    </label>

                    <input type="number"
                           step="0.01"
                           name="amount"
                           value="{{ $product->amount }}"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Stock
                    </label>

                    <input type="number"
                           name="stock"
                           value="{{ $product->stock }}"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select name="status"
                            class="form-control">

                        <option value="draft" @selected($product->status == 'draft')>
                            Draft
                        </option>

                        <option value="pending" @selected($product->status == 'pending')>
                            Pending
                        </option>

                        <option value="approved" @selected($product->status == 'approved')>
                            Approved
                        </option>

                        <option value="rejected" @selected($product->status == 'rejected')>
                            Rejected
                        </option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Active Status
                    </label>

                    <select name="is_active"
                            class="form-control">

                        <option value="1" @selected($product->is_active == 1)>
                            Active
                        </option>

                        <option value="0" @selected($product->is_active == 0)>
                            Inactive
                        </option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Product Image
                    </label>

                    <input type="file"
                           name="image"
                           class="form-control">

                </div>

                @if($product->image)

                <div class="col-12 mb-3">

                    <img src="{{ asset('storage/'.$product->image) }}"
                         width="100"
                         style="border-radius:8px;">

                </div>

                @endif

                <div class="col-12 mb-3">

                    <label class="form-label">
                        Description
                    </label>

                    <textarea name="description"
                              rows="5"
                              class="form-control js-ckeditor">{{ $product->description }}</textarea>

                </div>

            </div>

            <button type="submit"
                    class="btn btn-primary">

                Update Product

            </button>

        </form>

    </div>

</div>

@endsection