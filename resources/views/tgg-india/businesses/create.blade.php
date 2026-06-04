@extends('tgg-india.layouts.app')

@section('title', 'Create Business | TGG Meta | TGG India')

@section('content')

<div class="admin-container">

    <h4 class="mb-3 trainer-heading">
        Create Business
    </h4>

    @include('tgg-india.layouts.includes.message')

    <div class="card p-3 p-md-4 mb-4">

        <form action="{{ route('tgg-india.businesses.store', ['role' => auth('web2')->user()->role_key]) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="row">

                @if(auth('web2')->user()->user_role == 1)
                <div class="col-md-6 mb-3">

                    <label class="form-label">Owner</label>

                    <select name="user_id" class="form-control" required>

                        <option value="">Select Owner</option>

                        @foreach($users as $user)

                            <option value="{{ $user->id }}">
                                {{ $user->name }} ({{ $user->email }})
                            </option>

                        @endforeach

                    </select>

                </div>
                @else
                  <input type="hidden" name="user_id" value="{{ auth('web2')->id() }}">
                @endif

                <div class="col-md-6 mb-3">

                    <label class="form-label">Business Name</label>

                    <input type="text"
                           name="title"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">CIN Number</label>

                    <input type="text"
                           name="code"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Phone</label>

                    <input type="text"
                           name="phone"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Email</label>

                    <input type="email"
                           name="email"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Website</label>

                    <input type="text"
                           name="website"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Logo</label>

                    <input type="file"
                           name="image"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Status</label>

                    <select name="status" class="form-control">

                        <option value="active">Active</option>
                        <option value="deactive">Deactive</option>

                    </select>

                </div>

                <div class="col-12 mb-3">

                    <label class="form-label">Address</label>

                    <textarea name="address"
                              class="form-control"
                              rows="3"></textarea>

                </div>

                <div class="col-12 mb-3">

                    <label class="form-label">Description</label>

                    <textarea name="description"
                              class="form-control js-ckeditor"
                              rows="5"></textarea>

                </div>

            </div>

            <button type="submit"
                    class="btn btn-primary save-button">

                Save

            </button>

        </form>

    </div>

</div>

@endsection