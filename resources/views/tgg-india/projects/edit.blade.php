@extends('tgg-india.layouts.app')

@section('title', 'Edit Project | TGG Meta | TGG India')

@section('content')

<div class="admin-container">

    <h4 class="mb-3 trainer-heading">
        Edit Project
    </h4>

    @include('tgg-india.layouts.includes.message')

    <div class="card p-3 p-md-4 mb-4">

        <form action="{{ route('tgg-india.projects.update', [$project->id,'role' => auth('web2')->user()->role_key]) }}"
              method="POST">

            @csrf
            @method('PUT')

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

                            <option value="{{ $business->id }}"
                                @if($project->business_id == $business->id) selected @endif>

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
                           value="{{ $project->name }}"
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
                           value="{{ $project->code }}"
                           class="form-control">

                </div>

                <!-- Amount -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Amount
                    </label>

                    <input type="number"
                           step="0.01"
                           name="amount"
                           value="{{ $project->amount }}"
                           class="form-control">

                </div>

                <!-- Start Date -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Start Date
                    </label>

                    <input type="date"
                           name="start_date"
                           value="{{ $project->start_date }}"
                           class="form-control">

                </div>

                <!-- End Date -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        End Date
                    </label>

                    <input type="date"
                           name="end_date"
                           value="{{ $project->end_date }}"
                           class="form-control">

                </div>

                <!-- Status -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select name="status" class="form-control">

                        <option value="pending"
                            @if($project->status == 'pending') selected @endif>
                            Pending
                        </option>

                        <option value="started"
                            @if($project->status == 'started') selected @endif>
                            Started
                        </option>

                        <option value="completed"
                            @if($project->status == 'completed') selected @endif>
                            Completed
                        </option>

                        <option value="hold"
                            @if($project->status == 'hold') selected @endif>
                            Hold
                        </option>

                        <option value="rejected"
                            @if($project->status == 'rejected') selected @endif>
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

                    <select name="facilitators[]"
                            class="form-control select2"
                            multiple>

                        @foreach($facilitators as $user)

                            <option value="{{ $user->id }}"
                                @if(in_array($user->id, $selectedFacilitators)) selected @endif>

                                {{ $user->name }}
                                ({{ $user->email }}) - ({{ $user->skills ?? 'No skills specified' }})

                            </option>

                        @endforeach

                    </select>

                </div>
                @endif

                @if(isAdmin() ||  auth('web2')->user()->role_key == 'facilitator') 
                    <!-- Freelancers -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Freelancers
                        </label>

                        <select name="freelancers[]"
                                class="form-control select2"
                                multiple>

                            @foreach($freelancers as $user)

                                <option value="{{ $user->id }}"
                                    @if(in_array($user->id, $selectedFreelancers)) selected @endif>

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
                              rows="5">{{ $project->description }}</textarea>

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