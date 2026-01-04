@extends('tgg-india.layouts.app')

@section('title', 'Create Donation | TGG Meta | TGG India')

@section('content')
<div class="admin-container">
    <h4 class="trainer-heading mb-3">Create Donation</h4>
    @include('tgg-india.layouts.includes.message')

    <div class="card p-3">
        <form action="{{ route('tgg-india.admin.donations.store') }}" method="POST">
            @csrf

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
                                data-pan="{{ $id_proof_number }}">
                              {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                {{-- <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control">
                </div> --}}

                

                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">PAN Card</label>
                    <input type="text" name="pan_card_number"  id="pan_card_number" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Amount (₹)</label>
                    <input type="number" step="0.01" name="amount" class="form-control" required>
                </div>

                {{-- <div class="col-md-6">
                    <label class="form-label">Purpose</label>
                    <input type="text" name="purpose" value="TGG-AID program" class="form-control">
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
                    <input type="text" name="receipt_number" value="" class="form-control">
                </div>

            </div>

            <button type="submit" class="btn btn-primary mt-3 save-button">Save</button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
//     document.getElementById('user_email').addEventListener('change', function () {
//     let selected = this.options[this.selectedIndex];

//     document.getElementById('name').value = selected.getAttribute('data-name') || '';
//     document.getElementById('phone').value = selected.getAttribute('data-phone') || '';
//     document.getElementById('pan_card_number').value = selected.getAttribute('data-pan') || '';
// });
</script>

<script>
$(document).ready(function () {

    // Initialize Select2
    $('#user_email').select2({
        placeholder: '-- Select User Email --',
        allowClear: true,
        width: '100%'
    });

    // On email select
    $('#user_email').on('select2:select select2:clear', function () {
        let selected = $(this).find(':selected');

        $('#name').val(selected.data('name') || '');
        $('#phone').val(selected.data('phone') || '');
        $('#pan_card_number').val(selected.data('pan') || '');
    });

});
</script>

@endpush