<!DOCTYPE html>
<html lang="en">
<head>
  <title>@yield('title', 'TGG Edge | TGG India Dashboard')</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{ asset('assets/tgg-india/images/tgg-india-fav.jpg') }}" type="image/x-icon">

  <!-- Fonts and Styles --> 
   <link rel="stylesheet" href="{{ asset('assets/fonts/fonts.css') }}">
  <!-- <link rel="stylesheet" href="{{ asset('assets/tgg-india/fonts/fontawesome.css') }}"> -->
  <link rel="stylesheet" href="{{ asset('assets/tgg-india/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
  <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
 <link rel="stylesheet" href="{{ asset('assets/tgg-india/css/header-footer.css') }}">

  <!-- {{-- Font Awesome (local, downloaded) --}}
  <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}"> -->

  {{-- Your custom styles --}}
  <link rel="stylesheet" href="{{ asset('assets/tgg-india/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/tgg-india/css/header-footer.css') }}">

  <!-- Choices.js CSS -->
  <link rel="stylesheet" href="{{ asset('assets/choices/choices.min.css') }}">

</head>

</head>

<body style="font-family: 'POPPINS'">
  @include('tgg-india.layouts.includes.header')

  <div class="container-fluid">
    <div class="row">
        @if(isset($is_sidebar) && $is_sidebar === false)
          <div class="col-md-12 tgg-content">
              @yield('content')
          </div>
        @else
        <div class="col-md-3 tgg-sidebar d-none d-lg-block">
          @if( isset(auth('web2')->user()->user_role) &&  auth('web2')->user()->user_role == 1 )
              @include('tgg-india.layouts.includes.admin-sidebar')
          @elseif( isset(auth('web2')->user()->user_role) &&  auth('web2')->user()->user_role == 2)
              @include('tgg-india.layouts.includes.trainer-sidebar')
          @elseif( isset(auth('web2')->user()->user_role) &&  auth('web2')->user()->user_role == 3)
              @include('tgg-india.layouts.includes.member-sidebar')
          @else
              @include('tgg-india.layouts.includes.trainer-sidebar')
          @endif
        </div>
        <div class="col-md-9 tgg-content">
            <!-- Hamburger button visible only on mobile -->
            <button class="btn btn-dark d-lg-none mb-2" id="mobileSidebarToggle">
                <i class="fas fa-bars"></i> Menu
            </button>
          @yield('content')
        </div>
    @endif
    </div>
  </div>

  <!-- Mobile Sidebar -->
<div id="mobileSidebar" class="mobile-sidebar d-lg-none">
    <div class="mobile-sidebar-content">
        <button type="button" class="btn-close text-reset mb-2" id="mobileSidebarClose"></button>
        @if( isset(auth('web2')->user()->user_role) && auth('web2')->user()->user_role == 1 )
            @include('tgg-india.layouts.includes.admin-sidebar')
        @elseif( isset(auth('web2')->user()->user_role) && auth('web2')->user()->user_role == 2 )
            @include('tgg-india.layouts.includes.trainer-sidebar')
        @elseif( isset(auth('web2')->user()->user_role) && auth('web2')->user()->user_role == 3 )
            @include('tgg-india.layouts.includes.member-sidebar')
        @else
            @include('tgg-india.layouts.includes.trainer-sidebar')
        @endif
    </div>
</div>

<script>
document.getElementById('mobileSidebarToggle').addEventListener('click', function() {
    document.getElementById('mobileSidebar').classList.add('active');
});

document.getElementById('mobileSidebarClose').addEventListener('click', function() {
    document.getElementById('mobileSidebar').classList.remove('active');
});
</script>

  @include('tgg-india.layouts.includes.footer')

  <!-- {{-- Needed for multiselect --}}
  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script> -->

  <!-- Choices.js JS -->
  <script src="{{ asset('assets/choices/choices.min.js') }}"></script>

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
  </script>

{{-- CKEditor 5 super-build --}}
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/super-build/ckeditor.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.js-ckeditor').forEach(function (el) {
        if (el.dataset.ckeditorInited) return;
        el.dataset.ckeditorInited = '1';

        CKEDITOR.ClassicEditor.create(el, {
            extraPlugins: [ MyCustomUploadAdapterPlugin ],

            // remove plugins you don’t need
            removePlugins: [
                'CKBox','CKFinder','CKFinderUploadAdapter','EasyImage',
                'RealTimeCollaborativeComments','RealTimeCollaborativeTrackChanges',
                'RealTimeCollaborativeRevisionHistory','PresenceList','Comments',
                'TrackChanges','TrackChangesData','RevisionHistory','Pagination',
                'WProofreader','MathType','DocumentOutline','ExportPdf','ExportWord',
                'TableOfContents',
                'FormatPainter',
                'Template',
                'SlashCommand',
                'PasteFromOfficeEnhanced'
            ],

            toolbar: [
                'heading', '|',
                'bold', 'italic', 'underline', 'link', '|',
                'bulletedList', 'numberedList', '|',
                'insertTable', 'blockQuote', 'imageUpload', 'undo', 'redo', '|',
                'sourceEditing' 
            ],

             htmlSupport: {
                allow: [
                    {
                        name: /.*/,        // allow all tags
                        attributes: true,  // keep all attributes
                        classes: true,     // keep classes
                        styles: true       // keep inline styles
                    }
                ]
            },

            image: {
                resizeUnit: '%',
                resizeOptions: [
                    { name: 'resizeImage:original', label: 'Original', value: null },
                    { name: 'resizeImage:25', label: '25%', value: '25' },
                    { name: 'resizeImage:50', label: '50%', value: '50' },
                    { name: 'resizeImage:75', label: '75%', value: '75' }
                ],
                toolbar: [
                    'imageStyle:inline',
                    'imageStyle:block',
                    'imageStyle:side',
                    '|',
                    'resizeImage',  
                    'imageTextAlternative'
                ]
            }
        }).then(editor => {
            // ✅ Default styles for text inside CKEditor
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
                if (data.url) {
                    resolve({ default: data.url });
                } else {
                    reject(data.error || 'Upload failed');
                }
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


  
  {{-- Dashboard Volunteer Javascipt support --}}
  @stack('scripts')

</body>
</html>
