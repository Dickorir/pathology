<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @section('title')
            | Pathology
        @show
    </title>
    <!--page level css-->
@include('layouts.pages_css')
@yield('header_styles')
<!--end of page level css-->
</head>

<body>
<!-- Header Start -->
<header>

</header>

<!-- //Header End -->

<!-- slider / breadcrumbs section -->
@yield('top')

<!-- Content --> <!--</section>-->
<section class="content">
    <div id="wrapper">

        @include('layouts._left_menu')

        <div id="page-wrapper" class="gray-bg">
            @include('layouts._horizontal_menu')

                    @yield('content')
            @include('layouts.footer')
        </div>
    </div>
</section>

<!-- Footer Section Start -->
<footer>

</footer>
<!--
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" data-original-title="Return to top"
   data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a> -->



<!--global js starts-->
<!--global js end-->
<!-- begin page level js -->
@include('layouts.pages_js')
@yield('footer_scripts')
<!-- end page level js -->

</body>

</html>
