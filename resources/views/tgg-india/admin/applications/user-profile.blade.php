@extends('tgg-india.layouts.app')

@section('title', 'User Profile | TGG Meta | TGG India')

@section('content')
<div class="container">
    <h2 class="page-heading">User Registration Requests</h2>
    <!-- @include('tgg-india.layouts.includes.message') -->
    @include('tgg-india.layouts.includes.message')

    {{-- Show only pending users --}}
        <div class="card mb-4 p-3">
            <div class="row">
                <div class="col-md-12">

                    <form action="{{ route('tgg-india.admin.users.profile.update', $user->id) }}" method="POST">
                        @csrf
                        <div class="row">

                        <div class="col-md-6 mb-3 page-text">
                            <label>Name:</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="col-md-6 mb-3 page-text">
                            <label>Email:</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="col-md-6 mb-3 page-text">
                            <label>Age:</label>
                            <input type="age" name="age" class="form-control" value="{{ old('age', $user->age) }}" required>
                        </div>

                        <div class="col-md-6 mb-3 page-text">
                            <label>Phone:</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                        </div>

                        <div class="col-md-6 mb-3 page-text">
                            <label>Address:</label>
                            <textarea name="address" class="form-control">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <div class="col-md-6 mb-3 page-text">
                            <label>RHM Number:</label>
                            <input type="text" name="rhm_number" class="form-control" value="{{ old('rhm_number', $user->rhm_number) }}">
                        </div>

                        @if($user->user_role != 2 && $user->modules->count() > 0) {{-- 2 = trainer --}}
                            <div class="col-md-6 mb-3 page-text">
                                <label>Modules:</label>
                                <ul class="list-group">
                                    @foreach($user->modules as $index => $module)
                                        <li class="list-group-item">{{$index+1  .'. '. $module->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        </div>
                        {{-- <div class="page-text">
                            <label>Password:</label>
                            <input type="text" name="password" class="form-control" value="{{ old('password', $user->password ) }}">
                        </div> --}}

                        <hr>

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

                        <div class="page-text mt-3">
                            <button type="submit" class="btn btn-primary page-button">Update User</button>
                        </div>
                    </form>

                    <hr>
                    <h5 class="page-heading"> Approval Status: </h5>  

                    <div class="d-flex ">
                       <div class="d-flex gap-2">
                            <a href="{{ route('tgg-india.admin.users.update.approval', [$user->id, 'action' => 'pending']) }}"
                            class="btn btn-warning text-white {{ $user->approval == 'pending' ? 'disabled' : '' }} page-button ">
                                Pending
                            </a>

                            <a href="{{ route('tgg-india.admin.users.update.approval', [$user->id, 'action' => 'accepted']) }}"
                            class="btn btn-success text-white {{ $user->approval == 'accepted' ? 'disabled' : '' }} page-button">
                                Accept
                            </a>

                            <a href="{{ route('tgg-india.admin.users.update.approval', [$user->id, 'action' => 'rejected']) }}"
                            class="btn btn-danger text-white {{ $user->approval == 'rejected' ? 'disabled' : '' }} page-button">
                                Reject
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
