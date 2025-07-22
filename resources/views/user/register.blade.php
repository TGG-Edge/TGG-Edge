@extends('user.layouts.app')

@section('title', 'User Registration - TGG Edge') 
@php
    $is_sidebar = false;
@endphp
@section('content')
<div class="container py-2 d-flex justify-content-center align-items-center my-2">
    <div class="card shadow rounded-4 p-4" style="max-width: 600px; width: 100%; background-color: #fff;">
        <h4 class="text-center mb-4">Register</h4>

        {{-- Info Section --}}
        <div class="mb-3">
            <p class="text-muted small">
                Welcome to the TGG Edge Registration Portal. This registration is intended for individuals who are participating in research projects under TGG initiatives. Please fill in your details accurately. Fields marked with * are mandatory.
            </p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('user.register.store', $user_type) }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                {{-- Name --}}
                <div class="mb-3 col-md-6">
                    <label class="form-label">Name *</label>
                    <input type="text" class="form-control" name="name" placeholder="Full name" required>
                </div>

                {{-- Age --}}
                <div class="mb-3 col-md-6">
                    <label class="form-label">Age *</label>
                    <input type="number" class="form-control" name="age" placeholder="Your age" required>
                </div>

                @if($user_type == 'researcher')
                {{-- Project Description --}}
                <div class="mb-3 col-12">
                    <label class="form-label">Project (Research Topic Description) *</label>
                    <textarea class="form-control" name="project" placeholder="Describe your research project here" rows="3" required></textarea>
                </div>
                @endif

                <div class="mb-3 col-md-6">
                    <label class="form-label">Email *</label>
                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                </div>

                {{-- Phone Number --}}
                <div class="mb-3 col-md-6">
                    <label class="form-label">Phone Number *</label>
                    <input type="text" class="form-control" name="number" placeholder="Mobile number" required>
                </div>

                {{-- Address --}}
                <div class="mb-3 col-md-6">
                    <label class="form-label">Address *</label>
                    <textarea class="form-control" name="address" placeholder="Full address" rows="2" required></textarea>
                </div>

                {{-- RHM Registration Number --}}
                <div class="mb-3 col-md-6">
                    <label class="form-label">RHM Registration Number *</label>
                    <input type="text" class="form-control" name="rhm_number" placeholder="If applicable" required>
                </div>

                @if($user_type == 'researcher')
                {{-- Research Assistance Checkbox --}}
                <div class="mb-3 col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="research_assistance" id="research_assistance">
                        <label class="form-check-label" for="research_assistance">
                            I would like to apply for Research Assistance
                        </label>
                    </div>
                </div>
                @endif
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn w-100 mt-2 text-white" style="background-color: #033576; border-color: #033576;">Register</button>

            {{-- Login Link --}}
            <p class="text-center mt-3 mb-0">Already registered? <a href="{{ route('user.login') }}">Login</a></p>
        </form>
    </div>
</div>
@endsection
