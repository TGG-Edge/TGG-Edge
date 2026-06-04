@extends('tgg-india.layouts.app')

@section('title', 'Profile | TGG Meta | TGG India')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-heading">USER PROFILE</h2>

    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tgg-india.freelancer.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3 page-text">
                <label>Image:</label>

                <input type="file" name="image" class="form-control page-inputtext" accept="image/*">

                @if(!empty($user->image))
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $user->image) }}"
                            style="width: 80px; height: 80px; object-fit: fill; border-radius: 8px;">
                    </div>
                @endif
            </div>
            <div class="col-md-6 mb-3 page-text">
                <label>Name:</label>
                <input type="text" name="name" class="form-control page-inputtext" value="{{ $user->name }}">
            </div>
            <div class="col-md-6 mb-3 page-text">
                <label>Email:</label>
                <input type="email" name="email" class="form-control page-inputtext" value="{{ $user->email }}" readonly>
            </div>
            <div class="col-md-6 mb-3 page-text">
                <label>Phone:</label>
                <input type="text" name="phone" class="form-control page-inputtext" value="{{ $user->phone }}">
            </div>
            <div class="col-md-6 mb-3 page-text">
                <label>Address:</label>
                <textarea name="address" class="form-control page-inputtext">{{ $user->address }}</textarea>
            </div>
           
            <div class="col-md-6 mb-3 page-text">
                <label>RHM Number:</label>
                <input type="text" name="rhm_number" class="form-control page-inputtext" value="{{ $user->rhm_number }}">
            </div>

            <div class="col-md-6 mb-3 page-text">
                <label>GST No:</label>
                <input type="text" name="gst_no" class="form-control page-inputtext" value="{{ $user->gst_no }}">
            </div>

            <div class="col-md-6 mb-3 page-text">
                <label>Skills:</label>
                <input type="text" name="skills" class="form-control page-inputtext" value="{{ $user->skills ?? '' }}" placeholder="Enter comma separated skills">
            </div>

            <div class="col-md-6 mb-3 page-text">
                <label>Type of Engagement:</label>
                <select name="type_of_engagement" class="form-control page-inputtext">
                    <option value="">-- Select --</option>
                    @foreach(getTypeOfEngagementOptions() as $key => $label)
                        <option value="{{ $key }}"
                            {{ (string)old('type_of_engagement', $user->type_of_engagement) === (string)$key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
          
        </div>

        <hr>

        @php
            $user = auth('web2')->user();
            $idProof = \App\Models\UserIdProofSecondary::where('user_id', $user->id)->first();
            $bankDetail = \App\Models\UserBankDetailSecondary::where('user_id', $user->id)->first();
        @endphp
       {{-- ===================== ID PROOF SECTION ===================== --}}
        <h5 class="page-heading mt-4">ID Proof Details</h5>
        <div class="row">
            <div class="col-md-4 mb-3 page-text">
                <label>Proof Type:</label>
                <select name="id_proof_type" class="form-control page-inputtext">
                    <option value="">-- Select Proof Type --</option>
                    {{-- <option value="Aadhaar" {{ (old('id_proof_type', $idProof?->id_proof_type) == 'Aadhaar') ? 'selected' : '' }}>Aadhaar</option> --}}
                    <option value="PAN" {{ (old('id_proof_type', $idProof?->id_proof_type) == 'PAN') ? 'selected' : '' }}>PAN</option>
                    {{-- <option value="Voter ID" {{ (old('id_proof_type', $idProof?->id_proof_type) == 'Voter ID') ? 'selected' : '' }}>Voter ID</option>
                    <option value="Driving License" {{ (old('id_proof_type', $idProof?->id_proof_type) == 'Driving License') ? 'selected' : '' }}>Driving License</option> --}}
                </select>
            </div>

            <div class="col-md-4 mb-3 page-text">
                <label>Proof Number:</label>
                <input type="text" name="id_proof_number" class="form-control page-inputtext" 
                       value="{{ old('id_proof_number', $idProof?->id_proof_number) }}" placeholder="Enter proof number">
            </div>

            <div class="col-md-4 mb-3 page-text">
                <label>Upload Proof File:</label>
                <input type="file" name="id_proof_file" class="form-control page-inputtext">
                @if(!empty($idProof?->id_proof_file))
                    <div class="mt-1">
                        <a href="{{ asset('storage/'.$idProof->id_proof_file) }}" target="_blank" class="text-primary">
                            View Uploaded File
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <hr>

        {{-- ===================== BANK DETAILS SECTION ===================== --}}
        <h5 class="page-heading mt-4">Bank Account Details</h5>
        <div class="row">
            <div class="col-md-4 mb-3 page-text">
                <label>Bank Name:</label>
                <input type="text" name="bank_name" class="form-control page-inputtext" 
                       value="{{ old('bank_name', $bankDetail?->bank_name) }}" placeholder="Enter bank name">
            </div>

            <div class="col-md-4 mb-3 page-text">
                <label>Account Holder Name:</label>
                <input type="text" name="account_holder_name" class="form-control page-inputtext" 
                       value="{{ old('account_holder_name', $bankDetail?->account_holder_name) }}" placeholder="Enter account holder name">
            </div>

            <div class="col-md-4 mb-3 page-text">
                <label>Account Number:</label>
                <input type="text" name="account_number" class="form-control page-inputtext" 
                       value="{{ old('account_number', $bankDetail?->account_number) }}" placeholder="Enter account number">
            </div>

            <div class="col-md-4 mb-3 page-text">
                <label>IFSC Code:</label>
                <input type="text" name="ifsc_code" class="form-control page-inputtext" 
                       value="{{ old('ifsc_code', $bankDetail?->ifsc_code) }}" placeholder="Enter IFSC code">
            </div>

            <div class="col-md-4 mb-3 page-text">
                <label>Branch Name:</label>
                <input type="text" name="branch_name" class="form-control page-inputtext" 
                       value="{{ old('branch_name', $bankDetail?->branch_name) }}" placeholder="Enter branch name">
            </div>

            <div class="col-md-4 mb-3 page-text">
                <label>Upload Cheque / Passbook:</label>
                <input type="file" name="bank_document" class="form-control page-inputtext">
                @if(!empty($bankDetail?->bank_document))
                    <div class="mt-1">
                        <a href="{{ asset('storage/'.$bankDetail->bank_document) }}" target="_blank" class="text-primary">
                            View Uploaded File
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <hr>
        <h5 class="page-heading">CHANGE PASSWORD</h5>
        <div class="row">
            <div class="col-md-6 mb-3 page-text">
                <label>Current Password:</label>
                <input type="password" name="current_password" class="form-control page-inputtext">
                <span class="input-group-text toggle-pass" style="cursor:pointer;height: 30px;">👁</span>
            </div>
            <div class="col-md-6 mb-3 page-text">
                <label>New Password:</label>
                <input type="password" name="new_password" class="form-control page-inputtext">
                <span class="input-group-text toggle-pass" style="cursor:pointer;height: 30px;">👁</span>
            </div>
            <div class="col-md-6 mb-3 page-text">
                <label>Confirm New Password:</label>
                <input type="password" name="new_password_confirmation" class="form-control page-inputtext">
                <span class="input-group-text toggle-pass" style="cursor:pointer;height: 30px;">👁</span>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3 page-button">Update Profile</button>
    </form>
</div>
@endsection
