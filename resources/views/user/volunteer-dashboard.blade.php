@extends('user.layouts.app')

@section('title', 'Volunteer Dashboard - TGG Edge')

@section('content')
<div class="main-container">
    <div class="para-text">
        <p>Hello <strong>{{ Auth::user()->name ?? 'User' }}</strong> (not <strong>{{ Auth::user()->name ?? 'User' }}</strong>? <a href="{{ route('user.logout') }}">Log out</a>)</p>

        <p><strong>WELCOME TO TGG-EDGE</strong></p>

        <p>It is a dynamic hub where ethical research meets grassroots action. This is where your inquiries, insights, and efforts converge to shape meaningful change through collaborative, well-coordinated projects.
            <!-- Read more button (visible initially) -->
        <button id="readMoreBtn" style="background: none; border: none; color: #007BFF; cursor: pointer; padding-left: 5px; font-size: 11px; padding-top: 0;">
            Read more
        </button>
        </p>

        <div id="moreText" style="display: none;">
            <p>
             As a volunteer or researcher, you are part of a unified ecosystem committed to experiential learning, rigorous documentation, and outcome-oriented exploration. Here, you’ll find streamlined tools to manage assignments, exchange knowledge, and align your work with the broader values of sustainability, compassion, and community empowerment.
            </p>

            <p>
              Let’s co-create solutions that bridge theory and practice, deepen local impact, and contribute to a global narrative of self-reliance and human unity. Welcome aboard and onward with purpose.
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

        <div class="top-section">
            <div class="projects-list">
                <h3>LISTS OF PROJECTS</h3>
                <p>Choose a project that interests you, click SHOW to view details, then APPLY.</p>
                <form action="{{route('user.project-collaboration.apply')}}" method="POST">
                    @csrf

                    <div class="scroll-box" id="projectList">
                        @if($projects->count() > 0)
                            @foreach($projects as $index => $project)
                                <div class="project-item">
                                    <label style="cursor: pointer;">
                                        <strong><input type="radio" name="project_id" value="{{ $project->id }}" required /> {{ $project->title }}</strong>
                                    </label>
                                    <button type="button" onclick="viewProject({{ json_encode($project->description) }})">SHOW</button>
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
                <h3>PROJECT DESCRIPTION</h3>
                <p id="description" class="placeholder">
                    This is a detailed description of the selected project. When you click SHOW, this area will show project details in about 200 words.
                </p>
            </div>
        </div>

        <div class="info-fields">
            <div class="field-box">
                <label>Selected Project</label>
                <input type="text" class="classtext" readonly value="{{ $selected_project->project->title  ?? 'N/A'}}" />
            </div>
            <div class="field-box">
                <label>Researcher</label>
                <input type="text"  class="classtext" readonly value="{{ $selected_project->project->researcher    ->name ?? 'N/A'}}" />
            </div>
            <div class="field-box">
                <label>Application Status</label>
                @if( $selected_project && $selected_project->status == 'running')
                <input type="text" class="classtext" readonly value="Processing" />

                @else
                <input type="text" class="classtext" readonly value="{{ $selected_project->status ?? 'N/A'}}" />
                @endif
            </div>
        </div>

        <section class="volunteer-status">
            <h3>RESEARCH VOLUNTEERING STATUS</h3>
            <table>
                <colgroup>
                    <col style="width: 18%;"> 
                    <col style="width: 28%;"> 
                    <col style="width: 12%;"> 
                    <col style="width: 15%;"> 
                    <col style="width: 15%;"> 
                    <col style="width: 12%;"> 
                </colgroup>
                <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>Upload your research</th>
                        <th>Date</th>
                        <th>Progress %</th>
                        <th>Evaluation %</th>
                        <th>Update</th>
                    </tr>
                </thead>
               
                    <tbody>
                        @if($collaborated_projects->count() > 0)
                            
                            @foreach($collaborated_projects as $index => $project)
                             <form action="{{ route('user.project-collaboration.progress.update') }}" method="POST">
                    @csrf
                                <input type="hidden" name="collaborated_project_id" value="{{$project->collaborations[0]->id}}">
                                <tr>
                                    <td>{{ $project->title }}</td>
                                    <td>
                                        @if(!empty($project->collaborations[0]->document_url))
                                            <a href="{{ $project->collaborations[0]->document_url }}" target="_blank">
                                               Worksheet by researcher
                                            </a>
                                        @else
                                            N/A
                                        @endif
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
                                       {{  $project->collaborations[0]->researcher_progress_percentage ?? 'N/A' }}
                                    </td>
                                    <td><button type="submit" name="project_id" value="{{ $project->id }}">UPDATE</button></td>
                                </tr>
                </form>

                            @endforeach
                        
                        @else
                         <tr>
                            <td colspan="6">Collaborated projects not available</td>
                        </tr>
                        @endif
                    </tbody>
            </table>
        </section>
</div>
    
@endsection


{{-- Dashboard Volunteer Javascipt --}}

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // --- Handle "Read more"
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
