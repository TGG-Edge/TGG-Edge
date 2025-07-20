@extends('user.layouts.app')

@section('title', 'User Dashboard - TGG Edge')

@section('content')
<div class="main-container">
    <p>Hello <strong>{{ Auth::user()->name ?? 'User' }}</strong> (not <strong>{{ Auth::user()->name ?? 'User' }}</strong>? <a href="{{ route('user.logout') }}">Log out</a>)</p>

    <p><strong>Welcome to TGG India!</strong></p>

    <p>We are delighted to have you join us on this transformative journey. TGG India has been initiated with the vision of providing a holistic learning experience, remote working opportunities, and impactful community development initiatives. Our collective goal is to foster happiness and mindful living, which is at the core of Project Shambala.
    </p>

    <div id="moreText" style="display: none;">
        <p>
            As the world evolves with rapid technological advancements,
            the challenges of navigating this complex landscape are becoming increasingly evident.
            Unfortunately, technology’s misuse has led to disconnection, stress, and uncertainty for many.
            Project Shambala stands as a beacon of hope, guiding individuals toward a more meaningful and balanced life.
        </p>

        <p>
            Through our programs, we aspire to build a community that nurtures knowledge,
            collaboration, and conscious living. Together, we can create a safe space for those seeking
            an alternative to the fast-paced, often overwhelming modern lifestyle.
            Our collective efforts will pave the way for many who wish to break free from the vicious cycle that entraps them.
        </p>

        <p>
            Let us work hand in hand to build a future where learning, working, and living harmoniously
            with nature and society become the foundation of true well-being.
            Welcome to a community that believes in the power of mindful transformation!
        </p>

        <p>With gratitude,<br><strong>TGG Family</strong></p>

    </div>

    <button id="toggleBtn" style="background: none; border: none; color: #007BFF; cursor: pointer; padding-left: 5px;">
        Read more
    </button>

    {{-- Dashboard Volunteer HTML --}}

        {{-- Dashboard Volunteer HTML --}}

<div class="top-row" style="display: flex; gap: 20px; flex-wrap: wrap;">

    <!-- Left: Update Your Research Project -->
    <div class="section update-box" style="flex: 1;">
        <h3>UPDATE YOUR RESEARCH PROJECT</h3>
        <label>Provide a concise research title within 20 characters here</label>
        <input type="text" maxlength="25" placeholder="in twenty-five characters" />

        <label>Briefly describe your research project (max 200 words)</label>
        <textarea maxlength="200" rows="5" placeholder="in 200 words"></textarea>

        <button>SUBMIT</button>
    </div>

    <!-- Right: Volunteers Application -->
    <div class="section volunteer-box" style="flex: 1;">
        <h3>VOLUNTEERS APPLICATION</h3>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Whatsapp</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach(range(1, 7) as $i)
                <tr>
                    <td>Sweety {{ $i }}</td>
                    <td>9953296471</td>
                    <td>
                        <button>ACCEPT</button>
                        <button>REJECT</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- === MIDDLE SECTION: Research Project Progress === -->
<div class="section full-width" style="margin-top: 40px;">
    <h3>RESEARCH PROJECT PROGRESS</h3>
    <table>
        <thead>
            <tr>
                <th>Researcher Name</th>
                <th>Upload your main research page</th>
                <th>Date</th>
                <th>Progress %</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Name1</td>
                <td><input type="url" placeholder="Google word file link created by researcher" /></td>
                <td><input type="text" placeholder="Today's date" class="auto-date" /></td>
                <td><input type="number" value="10" min="0" max="100" /></td>
                <td><button>UPDATE</button></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- === BOTTOM SECTION: Research Volunteering Status === -->
<div class="section full-width" style="margin-top: 40px;">
    <h3>RESEARCH VOLUNTEERING STATUS</h3>
    <table>
        <thead>
            <tr>
                <th>Volunteer Name</th>
                <th>Upload your research page</th>
                <th>Date</th>
                <th>Progress % by Volunteer</th>
                <th>Progress % by Researcher</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
            @foreach(range(1, 3) as $i)
            <tr>
                <td>{{ $i === 1 ? 'Name1' : '' }}</td>
                <td><input type="url" placeholder="Paste Google Word link" /></td>
                <td><input type="text" placeholder="Today's date" class="auto-date" /></td>
                <td><input type="number" value="{{ $i === 1 ? 10 : 0 }}" readonly /></td>
                <td><input type="number" value="0" min="0" max="100" /></td>
                <td><button>SUBMIT</button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

    
@endsection


{{-- Dashboard Volunteer Javascipt --}}

@push('scripts')
<script>
    // === Auto-fill today's date for inputs with class "auto-date"
    const today = new Date().toISOString().split("T")[0];
    document.querySelectorAll('.auto-date').forEach(input => {
        input.value = today;
    });
</script>
@endpush
