@extends('user.layouts.app')

@section('title', 'Researcher Dashboard - TGG Edge')

@section('content')
<div class="main-container">
    <div class="para-text">
        <p>Hello <strong>{{ Auth::user()->name ?? 'Researcher' }}</strong> (not <strong>{{ Auth::user()->name ?? 'Researcher' }}</strong>? <a href="{{ route('user.logout') }}">Log out</a>)</p>

        <p><strong>Welcome to TGG India!</strong></p>

        <p>We are delighted to have you join us on this transformative journey. TGG India has been initiated with the vision of providing a holistic learning experience, remote working opportunities, and impactful community development initiatives. Our collective goal is to foster happiness and mindful living, which is at the core of Project Shambala.
        <!-- Read more button (visible initially) -->
        <button id="readMoreBtn" style="background: none; border: none; color: #007BFF; cursor: pointer; padding-left: 5px; font-size: 11px; padding-top: 0;">
            Read more
        </button>
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

            <p>With gratitude,<br><strong>TGG Family</strong>
                <!-- Read less button -->
            <button id="readLessBtn" style="background: none; border: none; color: #007BFF; cursor: pointer; padding-left: 5px; font-size: 11px;">
                Read less
            </button>
            </p>

        </div>
    </div>

    

    @include('user.layouts.includes.message')

    {{-- Dashboard Volunteer HTML --}}

        {{-- Dashboard Volunteer HTML --}}

<div class="top-row" style="display: flex; gap: 20px; flex-wrap: wrap;">

    <!-- Left: Update Your Research Project -->
   <div class="section update-box" style="flex: 1;">
    <form action="{{ route('user.project.store') }}" method="POST" enctype="multipart/form-data">
        @csrf 
        <h3>UPDATE YOUR RESEARCH PROJECT</h3>

        <label>Provide a concise research title within 30 characters here</label>
        <input name="title" type="text" maxlength="30" 
               placeholder="in twenty-five characters" 
               value="{{ old('title', $project->title ?? '') }}" required />

        <label>Briefly describe your research project (max 300 words)</label>
        <textarea name="description" rows="5" placeholder="in 300 words">{{ old('description', $project->description ?? '') }}</textarea>


            <button type="submit">Update</button>
        </form>
    </div>

    <!-- Right: Volunteers Application -->
    <div class="section volunteer-box" style="flex: 1;">
        <h3>VOLUNTEERS APPLICATION</h3>
        <table class="researcher-table">
            <thead>
                <colgroup>
                    <col style="width: 30%;"> 
                    <col style="width: 35%;"> 
                    <col style="width: 35%;">
                </colgroup>
                <tr>
                    <th>Name</th>
                    <th>Whatsapp</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if($volunteer_applications->count() > 0)
                    @foreach($volunteer_applications as $volunteer_application)
                        <tr>
                            <td>{{ $volunteer_application->volunteer->name }}</td>
                            <td>{{ $volunteer_application->volunteer->phone }}</td>
                            <td>
                                <form action="{{ route('user.project-collaboration.application/accept-reject') }}" method="POST" style="">
                                    @csrf
                                    <input type="hidden" name="project_collaboration_id" value="{{ $volunteer_application->id }}">
                                    <button name="action" value="accept" class="btn-accept">ACCEPT</button>
                                    <button name="action" value="reject" class="btn-reject">REJECT</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">VOLUNTEER APPLICATIONS NOT AVAILABLE</td>
                    </tr>
                @endif
            </tbody>
        </table class="researcher-table">
    </div>
</div>

<!-- === MIDDLE SECTION: Research Project Progress === -->
<div class="section full-width" style="margin-top: 40px;">
    <h3 class="sec-heading">RESEARCH PROJECT PROGRESS</h3>
    <table class="researcher-table">
        <colgroup>
            <col style="width: 15%;"> 
            <col style="width: 30%;"> 
            <col style="width: 20%;"> 
            <col style="width: 15%;"> 
            <col style="width: 15%;"> 
        </colgroup>
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
            <form action="{{ route('user.project-progress.update') }}" method="POST" enctype="multipart/form-data">
                <tr>
                @if($project)
                 @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <td>{{$project->title}}</td>
                <td>
                    <input type="url" name="document_url" value="{{$project->document_url ?? null}}">
                    
                </td>

                <td>{{$project->updated_at}}</td>
                <td><input name="progress_percentage"  value="{{ old('progress_percentage', $project->progress_percentage ?? '') }}" type="number" value="10" min="0" max="200" /></td>
                <td><button>UPDATE</button></td>
                @else
                 <tr>
                        <td colspan="6">PROJECT NOT AVAILABLE</td>
                </tr>
                @endif
            </tr>
            </form>
        </tbody>
    </table class="researcher-table">
</div>

<!-- === BOTTOM SECTION: Research Volunteering Status === -->
<div class="section full-width" style="margin-top: 40px;">
    <h3>RESEARCH VOLUNTEERING STATUS</h3>
    <table class="researcher-table">
        <colgroup>
            <col style="width: 15%;"> 
            <col style="width: 30%;"> 
            <col style="width: 19%;"> 
            <col style="width: 12%;"> 
            <col style="width: 12%;"> 
            <col style="width: 12%;"> 
        </colgroup>
        <thead>
            <tr>
                <th>Volunteer Name</th>
                <th>Upload your research page</th>
                <th>Date</th>
                <th>Progress % </th>
                <th>Evaluation % </th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
            @if($collaborated_projects->count() > 0)
            @foreach( $collaborated_projects as $collaborated_projects)
            <form action="{{ route('user.project-collaboration-progress.update') }}" method="POST">
                @csrf
                <input type="hidden" name="collaborated_project_id" value="{{$collaborated_projects->id}}">
            <tr>
                <td>{{ $collaborated_projects->volunteer->name }}</td>
                <td>
                        <input type="url" name="document_url" value="{{$collaborated_projects->document_url ?? null}}">

                </td>

                <td>{{$collaborated_projects->updated_at}}</td>
                <td><input type="number" class="progress-input"  value="{{old('progress_percentage',$collaborated_projects->progress_percentage ?? 'N/A')}}" readonly /></td>
                <td><input type="number" class="progress-input" name="researcher_progress_percentage" value="{{old('researcher_progress_percentage',$collaborated_projects->researcher_progress_percentage ?? 'N/A')}}" min="0" max="200" /></td>
                <td><button>SUBMIT</button></td>
            </tr>
            </form>
            @endforeach
            @else
              <tr>
                        <td colspan="6">VOLUNTEER APPLICATIONS NOT AVAILABLE</td>
                </tr>
            @endif
        </tbody>
    </table class="researcher-table">
</div>

    
@endsection


{{-- Dashboard Volunteer Javascipt --}}

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
     const readMoreBtn = document.getElementById('readMoreBtn');
    const readLessBtn = document.getElementById('readLessBtn');
    const moreText = document.getElementById('moreText');

    readMoreBtn.addEventListener('click', function () {
        moreText.style.display = 'block';
        readMoreBtn.style.display = 'none';
    });

    readLessBtn.addEventListener('click', function () {
        moreText.style.display = 'none';
        readMoreBtn.style.display = 'inline';
    });

    // === Auto-fill today's date ===
    const today = new Date().toISOString().split("T")[0];
    document.querySelectorAll('.auto-date').forEach(input => input.value = today);

    // === 200-Word Limit for Textarea ===
    const descriptionInput = document.querySelector('textarea[name="description"]');

    if (descriptionInput) {
        const getWordCount = (text) => {
            const cleaned = text.replace(/\n/g, ' ').replace(/\s+/g, ' ').trim();
            return cleaned ? cleaned.split(' ').length : 0;
        };

        const allowedKeys = [
            'Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown',
            'Tab', 'Control', 'Meta', 'Alt', 'Shift', 'Home', 'End'
        ];

        // Block typing after 200 words unless replacing text
        descriptionInput.addEventListener('keydown', function (e) {
            const wordCount = getWordCount(this.value);

            if (wordCount >= 200 && !allowedKeys.includes(e.key)) {
                const selection = this.value.substring(this.selectionStart, this.selectionEnd);
                const isReplacing = selection.length > 0;

                if (!isReplacing) {
                    e.preventDefault();
                }
            }
        });

        // Trim pasted content to 200 words
        descriptionInput.addEventListener('input', function () {
            let words = this.value.replace(/\n/g, ' ').replace(/\s+/g, ' ').trim().split(' ');
            if (words.length > 200) {
                this.value = words.slice(0, 200).join(' ');
                alert("Only 200 words allowed.");
            }
        });

        // Prevent paste if overflows limit
        descriptionInput.addEventListener('paste', function (e) {
            const currentWords = getWordCount(this.value);
            const paste = (e.clipboardData || window.clipboardData).getData('text');
            const pasteWords = getWordCount(paste);

            if (currentWords + pasteWords > 200) {
                e.preventDefault();
                alert("Pasting this text would exceed the 200-word limit.");
            }
        });
    }
});
</script>
@endpush

