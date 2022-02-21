<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="TemplateMo">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap"
        rel="stylesheet">

    <title>@yield('page_title') | Blog </title>
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('blog/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('blog/assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('blog/assets/css/templatemo-stand-blog.css') }}">
    <link rel="stylesheet" href="{{ asset('blog/assets/css/owl.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  
    {{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <style>
        body {
            font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

    </style>
    @stack('css')
</head>

<body>
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->
    @include('user.user_layout.header')

    <div class="main-banner header-text">
        <div class="container-fluid">
            <div class="owl-banner owl-carousel">
                <div class="item">
                </div>
            </div>
        </div>
    </div>
    <section class="blog-posts">
        <div class="container">
            @yield('content')
        </div>
    </section>
    <!-- Bootstrap core JavaScript -->
    {{-- <script src="{{ asset('blog/vendor/jquery/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('blog/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <!-- Additional Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('blog/assets/js/custom.js') }}"></script>
    <script src="{{ asset('blog/assets/js/owl.js') }}"></script>
    <script src="{{ asset('blog/assets/js/slick.js') }}"></script>
    <script src="{{ asset('blog/assets/js/isotope.js') }}"></script>
    <script src="{{ asset('blog/assets/js/accordions.js') }}"></script>


    {{-- <script src="//code.jquery.com/jquery-1.9.1.js"></script> --}}
    {{-- <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script> --}}

    {{-- <script language="text/Javascript">
        cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
        function clearField(t) { //declaring the array outside of the
            if (!cleared[t.id]) { // function makes it static and global
                cleared[t.id] = 1; // you could use true and false, but that's more typing
                t.value = ''; // with more chance of typos
                t.style.color = '#fff';
            }
        }
    </script> --}}
    @stack('page_scripts')
</body>

</html>
