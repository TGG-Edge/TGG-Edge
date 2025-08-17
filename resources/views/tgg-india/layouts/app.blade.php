<!DOCTYPE html>
<html lang="en">
<head>
  <title>@yield('title', 'TGG Edge | TGG India Dashboard')</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{ asset('assets/tgg-india/images/tgg-fnd-logo-new.png') }}" type="image/x-icon">

  <!-- Fonts and Styles -->
   <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="{{ asset('assets/tgg-india/fonts/fontawesome.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/tgg-india/css/style.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/album/">
  <link rel='stylesheet' id='gutener-google-font-css'
        href='https://fonts.googleapis.com/css?family=Open+Sans%3A300%2C400%2C400i%2C600%2C700%2C800%7CPoppins%3A300%2C400%2C400i%2C500%2C600%2C700%2C800%2C900&#038;display=swap&#038;ver=6.8.1'
        type='text/css' media='all' />
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
 <link rel="stylesheet" href="{{ asset('assets/tgg-india/css/header-footer.css') }}">

 {{-- Bootstrap (local) --}}
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

  {{-- Font Awesome (local, downloaded) --}}
  <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">

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
        <div class="col-md-3 tgg-sidebar">
          @if( isset(auth()->user()->user_role) &&  auth()->user()->user_role == 1 || request()->is('tgg-edge/tgg-india/admin/*'))
              @include('tgg-india.layouts.includes.admin-sidebar')
          @elseif( isset(auth()->user()->user_role) &&  auth()->user()->user_role == 2)
              @include('tgg-india.layouts.includes.trainer-sidebar')
          @else
              @include('tgg-india.layouts.includes.trainer-sidebar')
          @endif
        </div>
        <div class="col-md-9 tgg-content">
          @yield('content')
        </div>
    @endif
    </div>
  </div>

  @include('tgg-india.layouts.includes.footer')

  {{-- Needed for multiselect --}}
  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Choices.js JS -->
  <script src="{{ asset('assets/choices/choices.min.js') }}"></script>

  <script>
  document.addEventListener('DOMContentLoaded', function () {
      // Automatically apply Choices.js to all <select multiple>
      document.querySelectorAll('select[multiple]').forEach(function (el) {
          new Choices(el, {
              removeItemButton: true,
              placeholderValue: el.getAttribute('placeholder') || 'Select options',
              searchEnabled: true,
          });
      });
  });
  </script>

  {{-- CKEditor global initializer --}}
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
window.initCKEditors = function(selector = '.js-ckeditor', options = {}) {
    document.querySelectorAll(selector).forEach(function (el) {
        if (el.dataset.ckeditorInited) return;
        el.dataset.ckeditorInited = '1';

        ClassicEditor.create(el, {
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'underline', 'link', '|',
                'bulletedList', 'numberedList', '|',
                'insertTable', 'blockQuote', 'imageUpload', 'undo', 'redo'
            ]
        }).catch(console.error);
    });
};

// Base64 Upload Adapter
class Base64UploadAdapter {
    constructor(loader) {
        this.loader = loader;
    }
    upload() {
        return this.loader.file.then(file => new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = () => resolve({ default: reader.result });
            reader.onerror = err => reject(err);
            reader.readAsDataURL(file);
        }));
    }
    abort() {}
}

function MyCustomUploadAdapterPlugin(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new Base64UploadAdapter(loader);
    };
}

document.addEventListener('DOMContentLoaded', function () {
    initCKEditors();
});
</script>

  
  {{-- Dashboard Volunteer Javascipt support --}}
  @stack('scripts')

</body>
</html>
