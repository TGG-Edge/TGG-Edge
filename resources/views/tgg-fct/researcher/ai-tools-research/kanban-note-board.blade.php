@extends('tgg-fct.layouts.app')

@section('title', 'Kanban Note Board | AI Tools & Research Systems | Tgg Edge | Tgg Fct')

@section('content')
<div class="container">
    <!-- Page Heading -->
    <div class="page-header">
       <h3 class=" knowledge">
            <i class="fas fa-folder-open" style="color:#007bff;"></i> Kanban Note Board
        </h3>
        <p style=" color: #555; font-size: 10px;">
            Manage, organize your research Notes.
        </p>
    </div>

    
    <!-- Iframe Container -->
    <div class="card" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
        <div class="card-body" style="padding: 0;">
           <iframe 
                src="{{ url('/kanban') }}" 
                style="width:100%; height:90vh; border:none;" 
                frameborder="0" 
                allowfullscreen>
            </iframe>

        </div>
    </div>

</div>
@endsection
