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

        <div class="top-section">
            <div class="projects-list">
                <h3>List of Projects</h3>
                <p>Choose a project that interests you, click SHOW to view details, then APPLY.</p>
                <div class="scroll-box" id="projectList">
                    @php
                    $users = [
                        (object)['project' => 'Project Alpha'],
                        (object)['project' => 'Project Beta'],
                        (object)['project' => 'Project Gamma'],
                    ];
                    @endphp

                    @foreach($users as $index => $user)
                        <div class="project-item">
                            <span>{{ $user->project }}</span>
                            <button onclick="viewProject({{ $index }})">SHOW</button>
                        </div>
                    @endforeach
                </div>
                <button id="applyBtn">APPLY</button>
            </div>

            <div class="project-description">
                <h3>Project Description</h3>
                <p id="description" class="placeholder">
                    This is a detailed description of the selected project. When you click SHOW, this area will show project details in about 200 words.
                </p>
            </div>
        </div>

        <div class="info-fields">
            <div class="field-box">
                <label>Selected Project</label>
                <input type="text" readonly value="Organic skin care lotion" />
            </div>
            <div class="field-box">
                <label>Researcher</label>
                <input type="text" readonly value="Dr. Nisha Rao" />
            </div>
            <div class="field-box">
                <label>Application Status</label>
                <input type="text" readonly value="Pending" />
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
                        <th>Progress% Updated by Volunteer</th>
                        <th>Progress% Updated by Researcher</th>
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach([
                        'Anganwadi improvement',
                        'AI tool for video creation',
                        'Organic skin care lotion',
                        'Smart irrigation',
                        'AI voice assistant'
                    ] as $project)
                        <tr>
                            <td>{{ $project }}</td>
                            <td>
                            <input type="text" name="google_word_link" placeholder="Google word file link created by researcher" style="width: 100%;" />
                            </td>
                            <td class="date-cell"></td>
                            <td><input type="number" min="0" max="100" class="progress-input" placeholder="Enter %" /></td>
                            <td><input type="text" value="45%" readonly style="width: 80px; text-align: center;"/></td>
                            <td><button onclick="updateProgress(this)">UPDATE</button></td>
                        </tr>
                    @endforeach
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
        const moreText = document.getElementById("moreText");
    const toggleBtn = document.getElementById("toggleBtn");

    toggleBtn.addEventListener("click", () => {
        if (moreText.style.display === "none" || moreText.style.display === "") {
            moreText.style.display = "block";
            toggleBtn.textContent = "Read less";
            moreText.scrollIntoView({ behavior: "smooth" });
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
        document.getElementById("applyBtn").addEventListener("click", () => {
            if (selectedProjectName) {
                alert(`You applied for the project: "${selectedProjectName}"`);
            } else {
                alert("Please select a project using the SHOW button before applying.");
            }
        });
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

    function viewProject(index) {
         const desc = document.getElementById("description");
    desc.innerText = dummyDescriptions[index];
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
    selectedProjectName = projectTitles[index];

    // -------- Highlight Selected Project --------
    const items = document.querySelectorAll('.project-item');
    items.forEach(item => item.classList.remove('selected'));  // remove from all
    items[index].classList.add('selected');                    // add to selected
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
