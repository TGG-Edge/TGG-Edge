<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'TGG Edge | TGG India Dashboard')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('assets/tgg-india/images/tgg-india-fav.jpg') }}" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">

    <link rel="stylesheet" href="{{ asset('assets/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/tgg-india/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/tgg-india/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/tgg-india/css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/tgg-india/css/spouse-mobile-sidebar.css') }}"> 
    <link rel="stylesheet" href="{{ asset('assets/tgg-india/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/tgg-india/css/header-footer.css') }}"> 
    <link rel="stylesheet" href="{{ asset('assets/tgg-india/css/layout.css') }}">
    
    @if(!request()->routeIs('tgg-india.show') && !request()->routeIs('tgg-india.register.show'))
        <link rel="stylesheet" href="{{ asset('chatbot/css/chat-widget.css') }}">
        <script defer src="{{ asset('chatbot/js/chat-widget.js') }}"></script>
        <script defer src="{{ asset('chatbot/js/faqs.js') }}"></script>
        <script defer src="https://unpkg.com/alpinejs"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @endif

    @stack('styles')

   
</head>

<body style="font-family: 'Inter', sans-serif;">

    @include('tgg-india.layouts.includes.header')

    @php
        $sidebarView = 'tgg-india.layouts.includes.trainer-sidebar';
        $mobileSidebarView = 'tgg-india.layouts.includes.trainer-sidebar-mobile';
        if (auth('web2')->check()) {
            $role = auth('web2')->user()->user_role;
            $sidebarMap = [
                1 => 'admin-sidebar', 2 => 'trainer-sidebar', 3 => 'member-sidebar',
                6 => 'freelancer-sidebar', 7 => 'co-creator-sidebar', 8 => 'facilitator-sidebar', 9 => 'spouse-sidebar',
            ];
            $baseSidebar = $sidebarMap[$role] ?? 'trainer-sidebar';
            $sidebarView = 'tgg-india.layouts.includes.' . $baseSidebar;
            $mobileSidebarView = 'tgg-india.layouts.includes.' . $baseSidebar . '-mobile';
        }
    @endphp

    <div class="tgg-layout-container" id="layoutWrapper">

        @if(!(isset($is_sidebar) && $is_sidebar === false))
            <aside class="tgg-sidebar-wrapper d-none d-lg-flex" id="mainSidebar">
                <div class="sidebar-inner-scroll" style="overflow-y: auto; height: 100%; width: 100%;">
                    @include($sidebarView)
                </div>
                <div class="toggle-btn-container" id="sidebarToggle">
                    <x-ri-side-bar-line class="sidebar-toggle-btn"/>
                </div>
            </aside>

            <div class="tgg-mobile-overlay d-lg-none" id="mobileOverlay"></div>
            <aside class="tgg-mobile-sidebar-wrapper d-lg-none" id="mobileSidebar">
                @include($mobileSidebarView)
            </aside>
        @endif

        <main class="tgg-main-content">
            <div class="content-padding">
                @yield('content')
            </div>
        </main>
    </div>
    
    @include('tgg-india.layouts.includes.footer')
 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/super-build/ckeditor.js"></script>

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

            if(para && toggleBtn) {
                let lineHeight = parseFloat(window.getComputedStyle(para).lineHeight);
                let maxHeight = lineHeight * 8;

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
            }
        });

        document.querySelectorAll('.toggle-pass').forEach(btn => {
            btn.onclick = () => {
                let input = btn.previousElementSibling;
                input.type = input.type === "password" ? "text" : "password";
            };
        });

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

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const wrapper = document.getElementById('layoutWrapper');

        document.addEventListener('click', function(e) {
            if (e.target.closest('#sidebarToggle') || e.target.closest('.desktop-toggle')) {
                wrapper.classList.toggle('collapsed');
                const isCollapsed = wrapper.classList.contains('collapsed');
                localStorage.setItem('sidebar-state', isCollapsed ? 'collapsed' : 'open');
            }
        });

        const savedState = localStorage.getItem('sidebar-state');
        if (savedState === 'collapsed') {
            wrapper.classList.add('collapsed');
        }

        document.addEventListener('click', function(e) {
            const mobileSidebar = document.getElementById('mobileSidebar');
            const mobileOverlay = document.getElementById('mobileOverlay');

            if (e.target.closest('#mobileSidebarToggle')) {
                e.preventDefault(); 
                if (mobileSidebar) mobileSidebar.classList.add('active');
                if (mobileOverlay) mobileOverlay.classList.add('active');
            }

            if (e.target.closest('#mobileOverlay') || e.target.closest('#mobileSidebarClose')) {
                if (mobileSidebar) mobileSidebar.classList.remove('active');
                if (mobileOverlay) mobileOverlay.classList.remove('active');
            }
        });
    });
    </script>
    @endpush

    @stack('scripts')
</body>

</html>