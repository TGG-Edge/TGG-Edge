@extends('tgg-fct.layouts.app')

@php
    $is_sidebar = false
@endphp
@section('content')
<div class="container">
    <h2>Upload Sheet</h2>

    @if(session('error'))
      <div style="color:red">{{ session('error') }}</div>
    @endif

    <form action="{{ route('sheet.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept=".csv,.xls,.xlsx" required>
        <button type="submit">Upload & Visualize</button>
    </form>
</div>
@endsection
