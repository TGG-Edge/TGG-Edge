@extends('tgg-india.layouts.app')

@section('title', 'View Template')

@section('content')
<div class="admin-container">
<h4 class="trainer-heading">{{ $template->name }}</h4>

<div class="card p-3">
    <p><b>Type:</b> {{ ucfirst($template->type) }}</p>
    <p><b>Title:</b> {{ $template->title }}</p>

    <pre>{!! $template->content['body'] !!}</pre>
</div>
</div>
@endsection
