@extends('user.layouts.app')

@section('title', 'User Dashboard - TGG Edge')

@section('content')
<div class="main-container">
    <p>Hello <strong>{{ Auth::user()->name ?? 'User' }}</strong> (not <strong>{{ Auth::user()->name ?? 'User' }}</strong>? <a href="{{ route('user.logout') }}">Log out</a>)</p>

    <p><strong>Welcome to TGG India!</strong></p>

    <p>We are delighted to have you join us on this transformative journey. TGG India has been initiated with the vision of providing a holistic learning experience, remote working opportunities, and impactful community development initiatives. Our collective goal is to foster happiness and mindful living, which is at the core of Project Shambala.</p>

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

    <button id="toggleBtn" onclick="toggleReadMore()" style="background: none; border: none; color: #007BFF; cursor: pointer; padding: 0;">
        Read more
    </button>
    @include('user.layouts.includes.message')


    {{-- Dashboard Volunteer HTML --}}

        <div class="top-section">
            <div class="projects-list">
                <h3>List of Projects</h3>
                <p>Choose a project that interests you, click GO to view details, then APPLY.</p>
                <form action="{{route('user.project-collaboration.apply')}}" method="POST">
                    @csrf

                    <div class="scroll-box" id="projectList">
                        @if($projects->count() > 0)
                            @foreach($projects as $index => $project)
                                <div class="project-item">
                                    <label style="cursor: pointer;">
                                        <strong><input type="radio" name="project_id" value="{{ $project->id }}" required /> {{ $project->title }}</strong>
                                    </label>
                                    <button type="button" onclick="viewProject({{ json_encode($project->description) }})">GO</button>
                                </div>
                            @endforeach
                        @else
                            <div class="project-item">
                                No Project Available
                            </div>
                        @endif
                    </div>

                    <div style="margin-top: 15px;">
                        <button id="applyBtn" type="submit">APPLY</button>
                    </div>
                </form>
            </div>

            <div class="project-description">
                <h3>Project Description</h3>
                <p id="description" class="placeholder">
                    This is a detailed description of the selected project. When you click GO, this area will show project details in about 200 words.
                </p>
            </div>
        </div>

        <div class="info-fields">
            <div class="field-box">
                <label>Selected Project</label>
                <input type="text" readonly value="{{ $selected_project->project->title  ?? 'N/A'}}" />
            </div>
            <div class="field-box">
                <label>Researcher</label>
                <input type="text" readonly value="{{ $selected_project->project->researcher    ->name ?? 'N/A'}}" />
            </div>
            <div class="field-box">
                <label>Application Status</label>
                <input type="text" readonly value="{{ $selected_project->status ?? 'N/A'}}" />
            </div>
        </div>

        <section class="volunteer-status">
            <h3>Research Volunteering Status</h3>
            <table>
                <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>Upload your research</th>
                        <th>Date</th>
                        <th>Progress %</th>
                        <th>Research Progress %</th>

                        <th>Update</th>
                    </tr>
                </thead>
                <form action="{{ route('user.project-collaboration.progress.update') }}" method="POST">
                    @csrf
                    <tbody>
                        @if($collaborated_projects->count() > 0){
                            
                            @foreach($collaborated_projects as $index => $project)
                            
                                <input type="hidden" name="collaborated_project_id" value="{{$project->collaborations[0]->id}}">
                                <tr>
                                    <td>{{ $project->title }}</td>
                                    <td>
                                        {{ $project->collaborations[0]->document_url ?? 'N/A'}}
                                    </td>
                                    <td class="date-cell">{{ $project->collaborations[0]->updated_at }}</td>
                                    <td>
                                        <input type="number"  name="progress_percentage" 
                                            class="progress-input" 
                                            min="0" 
                                            max="100"
                                            value="{{ old("progress_percentage", $project->collaborations[0]->progress_percentage ?? '') }}" 
                                            placeholder="Enter %" 
                                            required>
                                    </td>
    
                                     <td>
                                        <input type="number"  name="researcher_progress_percentage" 
                                            class="progress-input" 
                                            min="0" 
                                            max="100"
                                            value="{{  $project->progress_percentage ?? 'N/A' }}" 
                                            placeholder="Enter %" 
                                            required readonly>
                                    </td>
                                    <td><button type="submit" name="project_id" value="{{ $project->id }}">UPDATE</button></td>
                                </tr>
                            @endforeach
                        }
                        @else
                         <tr>
                            <td colspan="6">Collaborated projects not available</td>
                        </tr>
                        @endif
                    </tbody>
                </form>
            </table>
        </section>
</div>
    
@endsection


{{-- Dashboard Volunteer Javascipt --}}

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // --- Handle "Read more"
        const toggleBtn = document.getElementById("toggleBtn");
        const moreText = document.getElementById("moreText");

        toggleBtn.addEventListener("click", () => {
            if (moreText.style.display === "none") {
                moreText.style.display = "block";
                toggleBtn.textContent = "Read less";
            } else {
                moreText.style.display = "none";
                toggleBtn.textContent = "Read more";
            }
        });

        // --- Set today's date in all date cells
        const today = new Date();
        const formatted = today.toLocaleDateString('en-IN', {
            day: '2-digit', month: '2-digit', year: 'numeric'
        });

        document.querySelectorAll(".date-cell").forEach(cell => {
            cell.textContent = formatted;
        });

        // --- Apply Button
        // document.getElementById("applyBtn").addEventListener("click", () => {
        //     if (selectedProjectName) {
        //         alert(`You applied for the project: "${selectedProjectName}"`);
        //     } else {
        //         alert("Please select a project using the GO button before applying.");
        //     }
        // });
    });

    let selectedProjectName = "";
    const dummyDescriptions = [
        "Detailed information about Anganwadi improvement project goes here...",
        "Details on the AI tool for video creation project...",
        "Organic skin care lotion development objectives and methodology...",
        "Smart irrigation using IoT sensors and data analysis...",
        "Voice recognition and automation for personal assistant...",
        "Logistics optimization using drones for last mile delivery...",
        "Chatbot interface for healthcare inquiries and triage...",
        "AI based system for real-time traffic management...",
        "Efficient tracking of waste bins and collection vehicles...",
        "Mobile app for farmers to monitor crop and soil health...",
    ];

    function viewProject(description) {
        const desc = document.getElementById("description");
        desc.innerText = description;
        desc.classList.remove("placeholder");

        const projectTitles = [
            "Anganwadi improvement",
            "AI tool for video creation",
            "Organic skin care lotion",
            "Smart irrigation",
            "AI voice assistant",
            "Drone-based delivery",
            "Healthcare chatbot",
            "Smart traffic monitoring",
            "Waste management tracker",
            "Mobile farming app",
        ];
        // selectedProjectName = projectTitles[index];
    }

    function updateProgress(button) {
        const row = button.closest("tr");
        const input = row.querySelector(".progress-input");
        const value = input.value;

        if (value && !isNaN(value) && value >= 0 && value <= 100) {
            button.textContent = `${value}%`;
            alert(`You completed ${value}% of the project.`);
        } else {
            alert("Please enter a valid percentage (0–100).");
        }
    }
</script>
@endpush
