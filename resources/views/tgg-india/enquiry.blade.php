@extends('tgg-india.layouts.app')

@section('title', 'Enquiry Form | TGG India')

@php
    $is_sidebar = false;
@endphp

@section('content')
    <div class="container py-4 ">
        <div class="card shadow rounded-4 p-4 ">
            @php
                $content = \App\Models\ContentPage::where('source_type', 'lead-referral')->first();
            @endphp
            {!! $content->content !!}

            <hr>
            <div class="card shadow rounded-4 p-4">
                <h4 class="text-center mb-3">Submit Your Enquiry</h4>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('tgg-india.enquiry.referral.store', $referral_code) }}">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Phone *</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control">
                        </div>

                        <div class="mb-3 col-md-12">
                            <label class="form-label">Role *</label>
                            <select name="role" class="form-select" required>
                                <option value="">Select Role</option>
                                <option value="Advisor">Advisor</option>
                                {{-- <option value="Trainer">Trainer</option>
                        <option value="Co-Creator">Co-Creator</option>
                        <option value="Facilitator">Facilitator</option> --}}
                            </select>
                        </div>

                        <div class="mb-3 col-12">
                            <label class="form-label">Message (Optional)</label>
                            <textarea name="message" rows="3" class="form-control" placeholder="Any specific details..."></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn w-100 text-white" style="background-color:#033576;">
                        Submit Enquiry
                    </button>
                </form>
            </div>
        </div>
        {{-- <hr> --}}

    </div>
@endsection
