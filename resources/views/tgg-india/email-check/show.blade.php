@extends('tgg-india.layouts.app')

@section('title', 'Email Check Result')

@section('content')
<div class="admin-container">

    <h4 class="trainer-heading mb-3">Email Check Details</h4>

    <div class="card p-3 mb-4">
        <div class="row">
            <div class="col-md-6"><strong>Name:</strong> {{ $email->name }}</div>
            <div class="col-md-6"><strong>Email:</strong> {{ $email->email }}</div>
            <div class="col-md-6"><strong>Valid:</strong> {{ $email->valid ? 'Yes' : 'No' }}</div>
        </div>
    </div>

    <div class="card p-3">
        <h6>DISIFY Result</h6>
        <table class="table table-bordered">
            <tr><th>Format</th><td>{{ $email->format ? 'Yes' : 'No' }}</td></tr>
            <tr><th>Domain</th><td>{{ $email->domain }}</td></tr>
            <tr><th>Disposable</th><td>{{ $email->disposable ? 'Yes' : 'No' }}</td></tr>
            <tr><th>DNS</th><td>{{ $email->dns ? 'Yes' : 'No' }}</td></tr>
            <tr><th>Whitelist</th><td>{{ $email->whitelist ? 'Yes' : 'No' }}</td></tr>
        </table>

        
    </div>

</div>
@endsection
