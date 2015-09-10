<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INELUCTABLE | Dashboard</title>

    <link rel="stylesheet"  href="{{ URL::asset('css/app.css') }}">
    <link rel="stylesheet"  href="{{ URL::asset('css/inspina.css') }}">
    <link rel="stylesheet"  href="{{ URL::asset('css/inspinacss.css') }}">

    @yield('header')

</head>

<body>

<div id="wrapper">

    @include('dashboard.partials.navbar')

    <div id="page-wrapper" class="gray-bg">
        @include('dashboard.partials.topbar')
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>@yield('heading')</h2>
                <ol class="breadcrumb">
                    @yield('breadcrumbs')
                </ol>
            </div>
            <div class="col-lg-2">

            </div>
        </div>
        @include('dashboard.partials.errors')
        <div class="wrapper wrapper-content animated fadeInRight">
            @yield('content')
        </div>
        @include('dashboard.partials.footer')

    </div>
</div>

<script type="text/javascript"  src="{{ URL::asset('js/all.js') }}" ></script>
<script type="text/javascript"  src="{{ URL::asset('js/inspina.js') }}" ></script>
<script type="text/javascript"  src="{{ URL::asset('assets/js/app.js') }}" ></script>

@include('dashboard.partials.flash');

@yield('scripts')

</body>

</html>
