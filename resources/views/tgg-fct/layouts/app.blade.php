<!DOCTYPE html>
<html lang="en">
<head>
  <title>@yield('title', 'TGG Edge | User Dashboard')</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{ asset('assets/user/images/tgg-fnd-logo-new.png') }}" type="image/x-icon">

  <!-- Fonts and Styles -->
   <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins" />
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"> -->
  <!-- <link rel="stylesheet" href="{{ asset('assets/user/fonts/fontawesome.css') }}"> -->
  <link rel="stylesheet" href="{{ asset('assets/user/css/style.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/album/">
  <link rel='stylesheet' id='gutener-google-font-css'
        href='https://fonts.googleapis.com/css?family=Open+Sans%3A300%2C400%2C400i%2C600%2C700%2C800%7CPoppins%3A300%2C400%2C400i%2C500%2C600%2C700%2C800%2C900&#038;display=swap&#038;ver=6.8.1'
        type='text/css' media='all' />
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

</head>

<body style="font-family: 'POPPINS'">
  @include('tgg-fct.layouts.includes.header')

  <div class="container-fluid">
   
    <div class="row">
    @if(isset($is_sidebar) && $is_sidebar === false)
    <div class="col-md-12 tgg-content">
        @yield('content')
      </div>
    @else
    
    <div class="col-md-3 tgg-sidebar">
      @if( isset(auth()->user()->user_role) &&  auth()->user()->user_role == 1 )
              @include('tgg-fct.layouts.includes.admin-sidebar')
      @elseif( isset(auth()->user()->user_role) &&  auth()->user()->user_role == 5)
          @include('tgg-fct.layouts.includes.assignee-sidebar')
      @else
          @include('tgg-fct.layouts.includes.sidebar')
      @endif
    </div>

    <div class="col-md-9 tgg-content">
     
      @yield('content')
    </div>
    @endif
    </div>
  </div>

  @include('tgg-fct.layouts.includes.footer')
  
  {{-- Dashboard Volunteer Javascipt support --}}
  @stack('scripts')

</body>
</html>
