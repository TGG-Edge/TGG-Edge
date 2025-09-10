@extends('tgg-india.layouts.app')

@section('title', 'Trainer Dashboard | TGG Meta | TGG India')


@section('content')
<div class="admin-container">
    {!! $showcase->welcome_note_trainer ?? 'Hello (not WELCOME TO TGG-EDGE)

It is a dynamic hub where ethical research meets grassroots action. This is where your inquiries, insights, and efforts converge to shape meaningful change through collaborative, well-coordinated projects.

As a volunteer or researcher, you are part of a unified ecosystem committed to experiential learning, rigorous documentation, and outcome-oriented exploration. Here, you’ll find streamlined tools to manage assignments, exchange knowledge, and align your work with the broader values of sustainability, compassion, and community empowerment.

Let’s co-create solutions that bridge theory and practice, deepen local impact, and contribute to a global narrative of self-reliance and human unity. Welcome aboard and onward with purpose.

With gratitude,
TGG Family
'; !!}

            
</div>
@endsection
