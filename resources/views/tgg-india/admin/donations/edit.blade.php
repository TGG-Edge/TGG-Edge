@extends('tgg-india.layouts.app')

@section('title', 'Edit Donation | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <h4 class="trainer-heading mb-3">Edit Donation</h4>
    @include('tgg-india.layouts.includes.message')

    <div class="card p-3">
        <form action="{{ route('tgg-india.admin.donations.update', $donation->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">


                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <select name="email" id="user_email" class="form-control select2">
                        <option value="">-- Select User Email --</option>

                        @foreach ($users as $user)
                            @php
                              $id_proof_number = \App\Models\UserIdProofSecondary::where('user_id', $user->id)->first()->id_proof_number ?? 'N/A';
                            @endphp
                            <option value="{{ $user->email }}"
                                data-name="{{ $user->name }}"
                                data-phone="{{ $user->phone }}"
                                data-pan="{{ $id_proof_number }}"
                                {{ $donation->email == $user->email ? 'selected' : '' }}>
                              {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" id="name" value="{{ $donation->name }}" class="form-control" required>
                </div>

                {{-- <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ $donation->email }}" class="form-control">
                </div> --}}

                

                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ $donation->phone }}" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">PAN Card</label>
                    <input type="text"  id="pan_card_number" name="pan_card_number"
                           value="{{ $donation->pan_card_number }}"
                           class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Amount (₹)</label>
                    <input type="number" step="0.01" name="amount"
                           value="{{ $donation->amount }}"
                           class="form-control" required>
                </div>

                {{-- <div class="col-md-6">
                    <label class="form-label">Purpose</label>
                    <input type="text" name="purpose"
                           value="{{ $donation->purpose }}"
                           class="form-control">
                </div> --}}

                <div class="col-md-6">
                <label class="form-label">Purpose</label>
                <select name="purpose" class="form-control" required>
                    <option value="">-- Select Purpose --</option>

                    @foreach (getReasonOfReward() as $key => $value)
                        <option value="{{ $key }}"
                            {{ old('purpose', $donation->purpose ?? '') == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-control" required>
                        <option value="">-- Select Type --</option>

                        @foreach (getDonationType() as $key => $value)
                            <option value="{{ $key }}"
                                {{ old('type', $donation->type ?? '') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
            </div>

                <div class="col-md-6">
                    <label class="form-label">Receipt Number</label>
                    <input type="text" name="receipt_number"
                           value="{{ $donation->receipt_number }}"
                           class="form-control">
                </div>
                

            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary save-button">Update</button>
                <a href="{{ route('tgg-india.admin.donations.index') }}" class="btn btn-secondary">Cancel</a>
            </div>

        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function () {

    // Initialize Select2
    $('#user_email').select2({
        placeholder: '-- Select User Email --',
        allowClear: true,
        width: '100%'
    });

    function fillUserData() {
        let selected = $('#user_email').find(':selected');

        $('#name').val(selected.data('name') || $('#name').val());
        $('#phone').val(selected.data('phone') || $('#phone').val());
        $('#pan_card_number').val(selected.data('pan') || $('#pan_card_number').val());
    }

    // On change
    $('#user_email').on('select2:select select2:clear', function () {
        fillUserData();
    });

    // 🔥 Auto-fill on edit page load
    fillUserData();

});
</script>
@endpush
