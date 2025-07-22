@extends('user.layouts.app')
@section('title', 'User Login - TGG Edge')
@php $is_sidebar = false; @endphp

@section('content')
<div class="container py-4">
    {{-- Top Description --}}
    <div class="text-center mb-4">
        <h2 class="fw-bold">Welcome to TGG Edge</h2>
        <p class="text-muted">TGG Foundation fosters inquiry-driven education where learners explore real-world challenges through research, reflection, and community engagement. Participants are encouraged to formulate questions, investigate ethical solutions, and apply their findings to transformative projects that promote sustainability and self-reliance. This immersive model cultivates critical thinking, creativity, and a deeper understanding of societal impact, empowering learners to become agents of meaningful change.</p>
    </div>

    {{-- Split Layout --}}
    <div class="row justify-content-center align-items-center">
        {{-- Left Image --}}
        <div class="col-md-7 d-none d-md-block text-center">
            <img src="{{ asset('assets/user/images/login-right.jpg') }}" alt="TGG Edge Login" class="img-fluid rounded-4 shadow" style="height: 500px">
        </div>

        {{-- Right Login Form --}}
        <div class="col-md-5 col-lg-5">
            <div class="card shadow rounded-4 p-4" style="background-color: #fff;">
                <h4 class="text-center mb-4">Login</h4>

                {{-- Flash Messages --}}
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

                {{-- Login Form --}}
                <form method="POST" action="{{ route('user.login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                    </div>
                    <button type="submit" class="btn w-100 mt-2 text-white" style="background-color: #033576; border-color: #033576;">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
