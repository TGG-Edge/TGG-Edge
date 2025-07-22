@extends('user.layouts.app')

@section('title', 'Admin Dashboard - TGG Edge')


@section('content')
            <p>Hello <strong>{{ Auth::user()->name ?? 'User' }}</strong> (not <strong>{{ Auth::user()->name ?? 'User' }}</strong>? <a href="{{ route('user.logout') }}">Log out</a>)</p>

            <p><strong>Welcome to TGG Edge!</strong></p>

            <p>We are delighted to have you join us on this transformative journey. TGG Edge has been initiated with the vision of providing a holistic learning experience, remote working opportunities, and impactful community development initiatives. Our collective goal is to foster happiness and mindful living, which is at the core of Project Shambala.</p>

            <p>As the world evolves with rapid technological advancements, the challenges of navigating this complex landscape are becoming increasingly evident. Unfortunately, technology’s misuse has led to disconnection, stress, and uncertainty for many. Project Shambala stands as a beacon of hope, guiding individuals toward a more meaningful and balanced life.</p>

            <p>Through our programs, we aspire to build a community that nurtures knowledge, collaboration, and conscious living. Together, we can create a safe space for those seeking an alternative to the fast-paced, often overwhelming modern lifestyle. Our collective efforts will pave the way for many who wish to break free from the vicious cycle that entraps them.</p>

            <p>Let us work hand in hand to build a future where learning, working, and living harmoniously with nature and society become the foundation of true well-being. Welcome to a community that believes in the power of mindful transformation!</p>

            <p>With gratitude,<br><strong>TGG Family</strong></p>
      
@endsection
