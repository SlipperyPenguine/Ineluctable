<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <title>NOWAY Alliance</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">


    <link rel="stylesheet"  href="{{ URL::asset('css/app.css') }}">
    <link rel="stylesheet"  href="{{ URL::asset('css/all.css') }}">

    @yield('header')

</head>

<body class="dark">

<div class="wrapper page-option-v1">
    @include('partials.navbar')

    @yield('content')

    @include('partials.footer')
</div><!--/wrapper-->

<!-- JS Global Compulsory -->
<script type="text/javascript"  src="{{ URL::asset('js/all.js') }}" ></script>


<script type="text/javascript"  src="{{ URL::asset('js/inspina.js') }}" ></script>

<!-- JS Page Level -->
<script type="text/javascript"  src="{{ URL::asset('assets/js/app.js') }}" ></script>

@include('dashboard.partials.flash')

@yield('scripts')

<script type="text/javascript">
    jQuery(document).ready(function() {
        App.init();

        @yield('jqueryreadyfunction')
    });
</script>


</body>
</html>