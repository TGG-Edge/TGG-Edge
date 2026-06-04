@extends('tgg-india.layouts.app')

@section('title', 'Create Product')

@section('content')

<div class="admin-container">

    <h4 class="trainer-heading mb-3">
        Create Product
    </h4>

    @include('tgg-india.layouts.includes.message')

    <div class="card p-4">

        <form action="{{ route('tgg-india.products.store',['role' => auth('web2')->user()->role_key]) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Product Title
                    </label>

                    <input type="text"
                           name="title"
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
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Stock
                    </label>

                    <input type="number"
                           name="stock"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select name="status"
                            class="form-control">

                        <option value="draft">Draft</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Active Status
                    </label>

                    <select name="is_active"
                            class="form-control">

                        <option value="1">
                            Active
                        </option>

                        <option value="0">
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

                <div class="col-12 mb-3">

                    <label class="form-label">
                        Description
                    </label>

                    <textarea name="description"
                              rows="5"
                              class="form-control js-ckeditor"></textarea>

                </div>

            </div>

            <button type="submit"
                    class="btn btn-primary">

                Save Product

            </button>

        </form>

    </div>

</div>

@endsection