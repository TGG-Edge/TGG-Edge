<!DOCTYPE html>
<html lang="en">
<head>
  <title>@yield('title', 'TGG Edge | User Dashboard')</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{ asset('assets/user/images/tgg-edge-logo.jpg') }}" type="image/x-icon">

  <!-- Fonts and Styles -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="{{ asset('assets/user/fonts/fontawesome.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/user/css/style.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  
</head>

<body>
  @include('user.layouts.includes.header')

  <div class="container-fluid">
   
    <div class="row">
    @if(isset($is_sidebar) && $is_sidebar === false)
 <div class="col-md-12 tgg-content">
        @yield('content')
      </div>
    @else
    
    <div class="col-md-3 tgg-sidebar">
      @include('user.layouts.includes.sidebar')
    </div>

    <div class="col-md-9 tgg-content">
      @yield('content')
    </div>
    @endif
    </div>
  </div>

  @include('user.layouts.includes.footer')
</body>
</html>
