<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'TGG Edge | TGG India Dashboard')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts(INTER) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">


    <link rel="icon" href="{{ asset('assets/tgg-india/images/tgg-india-fav.jpg') }}" type="image/x-icon">
    <!-- Fonts and Styles -->

    <link rel="stylesheet" href="{{ asset('assets/tgg-india/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/tgg-india/css/header-footer.css') }}">


    <style>
        /* --- 1. Global Setup --- */
        html,
        body {
            margin: 0;
            padding: 0;
            font-family: "Inter", sans-serif;
            background-color: #f8fafc;
        }

        .tgg-india-header {
            z-index: 1000;

        }

        /* --- 2. Layout Container --- */
        .tgg-layout-container {

            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* --- 3. Desktop Sidebar (Sticky) --- */
        .tgg-sidebar-wrapper {
            display: none;
            position: relative;
            width: 350px;
            flex-shrink: 0;
            background: #fff;
            border-right: 1px solid #e2e8f0;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);

            /* Sticky */
            position: sticky;
            top: 90px;
            height: calc(100vh - 90px);
        }

        .sidebar-toggle-btn {
            color: #000;
            ;
        }

        .toggle-btn-container {
            position: absolute;
            top: 30px;
            transform: translateY(-50%);
            right: -16px;
            z-index: 1050;
            cursor: pointer;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border: 1px solid #E5E7EB;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
        }

        .tgg-sidebar-wrapper::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        .tgg-sidebar-wrapper::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            -webkit-border-radius: 10px;
            border-radius: 10px;
        }

        .tgg-sidebar-wrapper::-webkit-scrollbar-thumb {
            -webkit-border-radius: 10px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.3);
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
        }

        .tgg-sidebar-wrapper::-webkit-scrollbar-thumb:window-inactive {
            background: rgba(255, 255, 255, 0.3);
        }

        /* --- 4. Main Content --- */
        .tgg-main-content {
            width: 100%;
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: #f8fafc;
            /* Removed overflow-y: auto so it pushes the page height naturally */
        }

        .content-padding {
            padding: 1rem;
            flex: 1 0 auto;
        }

        /* --- 5. Footer --- */
        .tgg-india-footer {
            width: 100%;
            background: #fff;
            border-top: 1px solid #e2e8f0;
        }

        /* --- Sidebar Collapsed State --- */
        .collapsed .tgg-sidebar-wrapper {
            width: 120px !important;
        }

        .collapsed .nav-label,
        .collapsed .logo-text,
        .collapsed .profile-info,
        .collapsed .chevron-icon {
            display: none !important;
        }

        .collapsed .nav-item {
            justify-content: center !important;

        }

        .collapsed .nav-item i {
            margin-right: 0 !important;
            font-size: 1.4rem !important;
        }

        /* --- Mobile Sidebar Styles --- */
        .tgg-mobile-sidebar-wrapper {
            position: fixed;
            top: 0;
            left: -300px;
            width: 280px;
            height: 100%;
            background: #fff;
            z-index: 1050;
            border-right: 1px solid #e2e8f0;
            transition: left 0.3s ease-in-out;
            overflow-y: auto;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
        }

        .tgg-mobile-sidebar-wrapper.active {
            left: 0;
        }

        .tgg-mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1040;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out;
        }

        .tgg-mobile-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        @media (min-width: 1040px) {
            .tgg-sidebar-wrapper {
                display: block;
            }
        }


        @media (max-width: 991.98px) {
            .tgg-sidebar-wrapper {
                width: 0px !important;
                border-right: none !important;
                overflow: hidden !important;
                padding: 0 !important;
            }
        }
    </style>


    @if (!request()->routeIs('tgg-india.show') && !request()->routeIs('tgg-india.register.show'))
        <link rel="stylesheet" href="{{ asset('chatbot/css/chat-widget.css') }}">
        <script src="{{ asset('chatbot/js/chat-widget.js') }}"></script>
        <script src="{{ asset('chatbot/js/faqs.js') }}"></script>
        <script defer src="https://unpkg.com/alpinejs"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @endif

    {{-- DYNAMIC VITE INJECTION --}}
    <link rel="stylesheet" href="{{ asset('assets/tgg-india/css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/tgg-india/css/spouse-mobile-sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/tgg-india/css/dashboard.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/choices/choices.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body style="font-family: 'Inter', sans-serif;">

    {{-- 1. HEADER RESTORED HERE --}}
    @include('tgg-india.layouts.includes.header')

    {{-- FIGURE OUT WHICH SIDEBAR TO SHOW --}}
    @php
        $sidebarView = 'tgg-india.layouts.includes.trainer-sidebar';
        $mobileSidebarView = 'tgg-india.layouts.includes.trainer-sidebar-mobile';
        if (auth('web2')->check()) {
            $role = auth('web2')->user()->user_role;
            $sidebarMap = [
                1 => 'admin-sidebar',
                2 => 'trainer-sidebar',
                3 => 'member-sidebar',
                6 => 'freelancer-sidebar',
                7 => 'co-creator-sidebar',
                8 => 'facilitator-sidebar',
                9 => 'spouse-sidebar',
            ];

            $baseSidebar = $sidebarMap[$role] ?? 'trainer-sidebar';

            // Define both Desktop and Mobile views
            $sidebarView = 'tgg-india.layouts.includes.' . $baseSidebar;
            $mobileSidebarView = 'tgg-india.layouts.includes.' . $baseSidebar . '-mobile';
        }
    @endphp

    {{-- MODERN FLEXBOX LAYOUT WRAPPER --}}
    <div class="tgg-layout-container" id="layoutWrapper">

        {{-- 2. WRAP BOTH SIDEBARS IN THE SIDEBAR CHECK --}}
        @if (!(isset($is_sidebar) && $is_sidebar === false))


            {{-- DESKTOP SIDEBAR --}}
            <aside class="tgg-sidebar-wrapper d-none d-lg-flex" id="mainSidebar">

                <div class="sidebar-inner-scroll" style="overflow-y: auto; height: 100%; width: 100%;">
                    @include($sidebarView)
                </div>


                <div class="toggle-btn-container" id="sidebarToggle">
                    <ri-menu-line class="sidebar-toggle-btn" />
                </div>
            </aside>

            {{-- MOBILE SIDEBAR & OVERLAY --}}
            <div class="tgg-mobile-overlay d-lg-none" id="mobileOverlay"></div>
            <aside class="tgg-mobile-sidebar-wrapper d-lg-none" id="mobileSidebar">
                @if (view()->exists($mobileSidebarView))
                    @include($mobileSidebarView)
                @endif
            </aside>

        @endif

        <main class="tgg-main-content">
            <div class="content-padding">
                @yield('content')
            </div>
            <x-app-modal />
        </main>

    </div>


    {{-- FOOTER OUTSIDE LAYOUT WRAPPER --}}
    @include('tgg-india.layouts.includes.footer')



    <!-- @push('scripts') -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const wrapper = document.getElementById('layoutWrapper');

                // --- DESKTOP Toggle Logic ---
                document.addEventListener('click', function(e) {
                    if (e.target.closest('#sidebarToggle') || e.target.closest('.desktop-toggle')) {
                        wrapper.classList.toggle('collapsed');
                        const isCollapsed = wrapper.classList.contains('collapsed');
                        localStorage.setItem('sidebar-state', isCollapsed ? 'collapsed' : 'open');
                    }
                });

                // Desktop Persistence
                const savedState = localStorage.getItem('sidebar-state');
                if (savedState === 'collapsed') {
                    wrapper.classList.add('collapsed');
                }

                // --- MOBILE Sidebar Logic (Fixed Overlay) ---
                document.addEventListener('click', function(e) {

                    const mobileSidebar = document.getElementById('mobileSidebar');
                    const mobileOverlay = document.getElementById('mobileOverlay');
                    const mobToggle = document.getElementById('mobileSidebarToggle');
                    const mobClose = document.getElementById('mobileSidebarClose');

                    // 1. Did they click the Open Button? (or an icon inside it)
                    if (e.target.closest('#mobileSidebarToggle')) {
                        e.preventDefault(); // Stop default button behavior
                        const mobileSidebar = document.getElementById('mobileSidebar');
                        const mobileOverlay = document.getElementById('mobileOverlay');

                        if (mobileSidebar) mobileSidebar.classList.add('active');
                        if (mobileOverlay) mobileOverlay.classList.add('active');
                    }

                    // 2. Did they click the Overlay OR the Close Button?
                    if (e.target.closest('#mobileOverlay') || e.target.closest('#mobileSidebarClose')) {
                        const mobileSidebar = document.getElementById('mobileSidebar');
                        const mobileOverlay = document.getElementById('mobileOverlay');

                        if (mobileSidebar) mobileSidebar.classList.remove('active');
                        if (mobileOverlay) mobileOverlay.classList.remove('active');
                    }
                });
            });
        </script>
    <!-- @endpush -->



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('select[multiple]').forEach(function (el) {
                new Choices(el, {
                    removeItemButton: true,
                    placeholderValue: el.getAttribute('placeholder') || 'Select options',
                    searchEnabled: true,
                });
            });
        });


        document.addEventListener("DOMContentLoaded", function () {
            const para = document.getElementById("expandWelcome");
            const toggleBtn = document.getElementById("toggleExpandWelcome");

            // Calculate max 8 lines height
            let lineHeight = parseFloat(window.getComputedStyle(para).lineHeight);
            let maxHeight = lineHeight * 8;

            // Show read more only if content overflows
            if (para.scrollHeight > maxHeight) {
                toggleBtn.style.display = "inline-block";
            }

            toggleBtn.addEventListener("click", function () {
                if (para.style.webkitLineClamp === "unset") {
                    para.style.webkitLineClamp = "8";
                    toggleBtn.innerText = "Read More";
                } else {
                    para.style.webkitLineClamp = "unset";
                    toggleBtn.innerText = "Read Less";
                }
            });
        });

        document.querySelectorAll('.toggle-pass').forEach(btn => {
            btn.onclick = () => {
                let input = btn.previousElementSibling;
                input.type = input.type === "password" ? "text" : "password";
            };
        });

    </script>

    {{-- CKEditor 5 --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/super-build/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.js-ckeditor').forEach(function (el) {
                if (el.dataset.ckeditorInited) return;
                el.dataset.ckeditorInited = '1';

                CKEDITOR.ClassicEditor.create(el, {
                    extraPlugins: [ MyCustomUploadAdapterPlugin ],
                    removePlugins: [
                        'Base64UploadAdapter','CKBox','CKFinder','CKFinderUploadAdapter','EasyImage',
                        'RealTimeCollaborativeComments','RealTimeCollaborativeTrackChanges',
                        'RealTimeCollaborativeRevisionHistory','PresenceList','Comments',
                        'TrackChanges','TrackChangesData','RevisionHistory','Pagination',
                        'WProofreader','MathType','DocumentOutline','ExportPdf','ExportWord',
                        'TableOfContents','FormatPainter','Template','SlashCommand',
                        'PasteFromOfficeEnhanced'
                    ],
                    toolbar: [
                        'heading', '|', 'bold', 'italic', 'underline', 'link', '|',
                        'bulletedList', 'numberedList', '|', 'insertTable', 'blockQuote',
                        'imageUpload', 'undo', 'redo', '|', 'sourceEditing'
                    ],
                    htmlSupport: {
                        allow: [{ name: /.*/, attributes: true, classes: true, styles: true }]
                    },
                    image: {
                        resizeUnit: '%',
                        resizeOptions: [
                            { name: 'resizeImage:original', label: 'Original', value: null },
                            { name: 'resizeImage:25', label: '25%', value: '25' },
                            { name: 'resizeImage:50', label: '50%', value: '50' },
                            { name: 'resizeImage:75', label: '75%', value: '75' },
                            { name: 'resizeImage:100', label: '100%', value: '100' }
                        ],
                        toolbar: [
                            'imageStyle:inline','imageStyle:block','imageStyle:side','|',
                            'resizeImage','imageTextAlternative'
                        ]
                    }
                }).then(editor => {
                    editor.editing.view.change(writer => {
                        writer.setStyle('font-size', '13px', editor.editing.view.document.getRoot());
                        writer.setStyle('color', '#000', editor.editing.view.document.getRoot());
                        writer.setStyle('font-family', 'poppins, system-ui, Arial, sans-serif', editor.editing.view.document.getRoot());
                    });
                    
                }).catch(console.error);
            });
        });

        class UploadAdapter {
            constructor(loader) { this.loader = loader; }
            upload() {
                return this.loader.file.then(file => new Promise((resolve, reject) => {
                    const data = new FormData();
                    data.append('upload', file);
                    data.append('_token', '{{ csrf_token() }}');
                    fetch('{{ route('ckeditor.upload') }}', {
                        method: 'POST',
                        body: data
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.url) resolve({ default: data.url });
                        else reject(data.error || 'Upload failed');
                    })
                    .catch(reject);
                }));
            }
            abort() {}
        }
        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = loader => new UploadAdapter(loader);
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            

            const modal = document.getElementById("appModal");

            const modalImage   = document.getElementById("modalImage");
            const modalTitle   = document.getElementById("modalTitle");
            const modalContent = document.getElementById("modalContent");
            const modalLink    = document.getElementById("modalLink");
            const videoWrapper = document.getElementById("modalVideoWrapper");
            const modalVideo   = document.getElementById("modalVideo");
            

            document.addEventListener("click", function (e) {
                const trigger = e.target.closest("[data-modal]");
                if (!trigger) return;
                
                // Get data
                const img   = trigger.dataset.img || "";
                const title = trigger.dataset.title || "";
                const note  = trigger.dataset.note || "";
                const link  = trigger.dataset.link || "";
                const video = trigger.dataset.video || "";  

                // Reset all
                modalImage.style.display = "none";
                modalTitle.style.display = "none";
                modalContent.style.display = "none";
                modalLink.style.display = "none";
                videoWrapper.style.display = "none";
                modalVideo.src = "";

                // Image
                if (img) {
                    modalImage.src = img;
                    modalImage.style.display = "block";
                }

                // Title
                if (title) {
                    modalTitle.innerText = title;
                    modalTitle.style.display = "block";
                }

                // Content
                if (note) {
                    modalContent.innerHTML = note;
                    modalContent.style.display = "block";
                }

                // Link
                if (link) {
                    modalLink.href = link;
                    modalLink.style.display = "inline-block";
                }

                // Convert YouTube link → embed
                if (video) {
                    let embedUrl = video;

                    try {
                        const url = new URL(video);

                        // Handle youtu.be short links
                        if (url.hostname.includes("youtu.be")) {
                            embedUrl = "https://www.youtube.com/embed/" + url.pathname.slice(1);
                        }

                        // Handle watch?v= links
                        else if (url.searchParams.get("v")) {
                            embedUrl = "https://www.youtube.com/embed/" + url.searchParams.get("v");
                        }

                    } catch (e) {
                        console.warn("Invalid URL:", video);
                    }

                    modalVideo.src = embedUrl;
                    videoWrapper.style.display = "block";
                }

                modal.style.display = "flex";
            });

            // Close button
            document.querySelector(".app-modal-close").onclick = () => {
                modal.style.display = "none";
            };

            // Outside click
            window.onclick = function (e) {
                if (e.target === modal) modal.style.display = "none";
            };
        });
    </script>

    @stack('scripts')
</body>

</html>
