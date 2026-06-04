@extends('tgg-india.layouts.app')

@section('title', 'Create Project | TGG Meta | TGG India')

@section('content')

<div class="admin-container">

    <h4 class="mb-3 trainer-heading">
        Create Project
    </h4>

    @include('tgg-india.layouts.includes.message')

    <div class="card p-3 p-md-4 mb-4">

        <form action="{{ route('tgg-india.projects.store', ['role' => auth('web2')->user()->role_key]) }}"
              method="POST">

            @csrf

            <div class="row">

                <!-- Business -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Business
                    </label>

                    <select name="business_id" class="form-control">

                        <option value="">
                            Select Business
                        </option>

                        @foreach($businesses as $business)

                            <option value="{{ $business->id }}">
                                {{ $business->title }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <!-- Name -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Project Name
                    </label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           required>

                </div>

                <!-- Code -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Project Code
                    </label>

                    <input type="text"
                           name="code"
                           class="form-control">

                </div>

                {{-- <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Project Code
                    </label>

                    <input type="text"
                           name="code"
                           class="form-control">

                </div> --}}

                <!-- Amount -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Amount
                    </label>

                    <input type="number"
                           step="0.01"
                           name="amount"
                           class="form-control">

                </div>

                <!-- Start Date -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Start Date
                    </label>

                    <input type="date"
                           name="start_date"
                           class="form-control">

                </div>

                <!-- End Date -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        End Date
                    </label>

                    <input type="date"
                           name="end_date"
                           class="form-control">

                </div>

                <!-- Status -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select name="status" class="form-control">

                        <option value="pending">
                            Pending
                        </option>

                        <option value="started">
                            Started
                        </option>

                        <option value="completed">
                            Completed
                        </option>

                        <option value="hold">
                            Hold
                        </option>

                        <option value="rejected">
                            Rejected
                        </option>

                    </select>

                </div>

                @if(auth('web2')->user()->role_key != 'facilitator')
                <!-- Facilitators -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Facilitators
                    </label>

                    <select name="facilitators[] "
                            class="form-control select2"
                                    >

                        @foreach($facilitators as $user)

                            <option value="{{ $user->id }}">
                                {{ $user->name }}
                                ({{ $user->email }}) - ({{ $user->skills ?? 'No skills specified' }})
                            </option>

                        @endforeach

                    </select>

                </div>
                @endif

                @if(isAdmin() || auth('web2')->user()->role_key == 'facilitator')
                    <!-- Freelancers -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Freelancers
                        </label>

                        <select name="freelancers[]"
                                class="form-control select2"
                                        >

                            @foreach($freelancers as $user)

                                <option value="{{ $user->id }}">
                                    {{ $user->name }}
                                    ({{ $user->email }}) - ({{ $user->skills ?? 'No skills specified' }})
                                </option>

                            @endforeach

                        </select>

                    </div>
                @endif

                <!-- Description -->
                <div class="col-12 mb-3">

                    <label class="form-label">
                        Description
                    </label>

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