@extends('tgg-fct.layouts.app')

@section('title', 'Research Material Organizer | AI Tools & Research Systems | Tgg Edge | Tgg Fct')

@section('content')
<div class="container">
    <!-- Page Heading -->
    <div class="page-header">
       <h3 class=" knowledge">
            <i class="fas fa-folder-open" style="color:#007bff;"></i> Research Material Organizer
        </h3>
        <p style=" color: #555; font-size: 10px;">
            Manage, upload, and organize your research files in one place.
        </p>
    </div>

 
    <!-- Iframe Container -->
    <div class="card" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
        <div class="card-body" style="padding: 0;">
            <iframe src="{{ url('/laravel-filemanager') }}" 
                    style="width:100%; height:90vh; border:none;">
            </iframe>
        </div>
    </div>

</div>
@endsection
