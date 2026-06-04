@extends('tgg-india.layouts.app')

@section('title', 'Edit Business | TGG Meta | TGG India')

@section('content')

<div class="admin-container">

    <h4 class="mb-3 trainer-heading">
        Edit Business
    </h4>

    @include('tgg-india.layouts.includes.message')

    <div class="card p-3 p-md-4 mb-4">

        <form action="{{ route('tgg-india.businesses.update', [$business->id, 'role' => auth('web2')->user()->role_key]) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="row">

                @if(auth('web2')->user()->user_role == 1)
                <div class="col-md-6 mb-3">

                    <label class="form-label">Owner</label>

                    <select name="user_id" class="form-control" required>

                        @foreach($users as $user)

                            <option value="{{ $user->id }}"
                                @if($business->user_id == $user->id) selected @endif>

                                {{ $user->name }} ({{ $user->email }})

                            </option>

                        @endforeach

                    </select>

                </div>
                @endif

                <div class="col-md-6 mb-3">

                    <label class="form-label">Business Name</label>

                    <input type="text"
                           name="title"
                           value="{{ $business->title }}"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">CIN Number</label>

                    <input type="text"
                           name="code"
                           value="{{ $business->code }}"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Phone</label>

                    <input type="text"
                           name="phone"
                           value="{{ $business->phone }}"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Email</label>

                    <input type="email"
                           name="email"
                           value="{{ $business->email }}"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Website</label>

                    <input type="text"
                           name="website"
                           value="{{ $business->website }}"
                           class="form-control">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Logo</label>

                    <input type="file"
                           name="image"
                           class="form-control">

                    @if($business->image)

                        <img src="{{ asset('storage/'.$business->image) }}"
                             width="70"
                             class="mt-2 rounded">

                    @endif

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">Status</label>

                    <select name="status" class="form-control">

                        <option value="active"
                            @if($business->status == 'active') selected @endif>
                            Active
                        </option>

                        <option value="deactive"
                            @if($business->status == 'deactive') selected @endif>
                            Deactive
                        </option>

                    </select>

                </div>

                <div class="col-12 mb-3">

                    <label class="form-label">Address</label>

                    <textarea name="address"
                              class="form-control"
                              rows="3">{{ $business->address }}</textarea>

                </div>

                <div class="col-12 mb-3">

                    <label class="form-label">Description</label>

                    <textarea name="description"
                              class="form-control js-ckeditor"
                              rows="5">{{ $business->description }}</textarea>

                </div>

            </div>

            <button type="submit"
                    class="btn btn-primary save-button">

                Update

            </button>

        </form>

    </div>

</div>

@endsection