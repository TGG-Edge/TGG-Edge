@extends('user.layouts.app')

@section('title', 'Admin Dashboard - TGG Edge')


@section('content')
<div class="admin-container">
            <p>Hello <strong>{{ Auth::user()->name ?? 'User' }}</strong> (not <strong>{{ Auth::user()->name ?? 'User' }}</strong>? <a href="{{ route('user.logout') }}">Log out</a>)</p>

            <p><strong>WELCOME TO TGG-EDGE</strong></p>

            <p>Welcome to the central workspace of TGG-Edge, a dynamic hub where ethical research meets grassroots action. This is where your inquiries, insights, and efforts converge to shape meaningful change through collaborative, well-coordinated projects.</p>

            <p>As a volunteer or researcher, you are part of a unified ecosystem committed to experiential learning, rigorous documentation, and outcome-oriented exploration. Here, you’ll find streamlined tools to manage assignments, exchange knowledge, and align your work with the broader values of sustainability, compassion, and community empowerment.
</p>

            <p>Let’s co-create solutions that bridge theory and practice, deepen local impact, and contribute to a global narrative of self-reliance and human unity. Welcome aboard and onward with purpose.</p>

            {{-- <p>Let us work hand in hand to build a future where learning, working, and living harmoniously with nature and society become the foundation of true well-being. Welcome to a community that believes in the power of mindful transformation!</p> --}}

            <p>With gratitude,<br><strong>TGG Family</strong></p>
</div>
@endsection
