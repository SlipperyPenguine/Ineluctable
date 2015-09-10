    <!--=== Header ===-->
    <div class="header">
        <div class="container" align="left">
            <!-- Logo -->
            <a class="logo" href="home">
                <img src="{{ URL::asset('assets/img/NOWAY-logo.png') }}" alt="Logo" height="40px">
            </a>
            <!-- End Logo -->


{{--            <!-- Topbar -->
            <div class="topbar">
                <ul class="loginbar pull-right">
                    @if (Auth::guest()) <li><a href="login">Login</a></li> @else <li><a href="logout">Logout</a></li> @endif
                </ul>
            </div>
            <!-- End Topbar -->--}}

            <span class="topbar pull-right"> @if (Auth::guest()) <a href="{{ URL::asset('auth/login') }}">Login / Register</a> @else <a href="{{ URL::asset('auth/logout') }}">Logout</a> @endif </span>



            <!-- Toggle get grouped for better mobile display -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="fa fa-bars"></span>
            </button>
            <!-- End Toggle -->
        </div><!--/end container-->

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse mega-menu navbar-responsive-collapse">
            <div class="container">


                <ul class="nav navbar-nav">
                    <!-- Home -->
                    <li>
                        <a href={{ URL::asset('home') }}>

                            <i class="fa fa-home"></i> Home
                        </a>
                    </li>
                    <!-- End Home -->

                    <!-- Forums -->
                    <li>
                        <a href="http://www.ineluctable.net/forums">
                            <i class="fa fa-comments-o"></i> Forums
                        </a>
                    </li>
                    <!-- End Forums -->

                    <!-- Killboard -->
                    <li>
                        <a href="http://www.ineluctable.net/killboard">
                            <i class="fa fa-space-shuttle"></i> Killboard
                        </a>
                    </li>
                    <!-- End Killboard -->

                    <!-- Fleet Up -->
                    <li>
                        <a href="http://www.fleet-up.com">
                            <i class="fa fa-calendar-o"></i> Fleet Up
                        </a>
                    </li>
                    <!-- End Fleet Up -->


                    <!-- Game Tools -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-cutlery"></i> Game Tools
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ URL::asset('indevelopment') }}"><i class="fa fa-angle-double-up"></i> dscan</a></li>
                            <li><a href="{{ URL::asset('indevelopment') }}"><i class="fa  fa-users"></i> local scan</a></li>
                            <li><a href="{{ URL::asset('indevelopment') }}"><i class="fa fa-ellipsis-h"></i> Fleet Tracker</a></li>
                            <li><a href="{{ URL::asset('entosis') }}"><i class="fa fa-calculator"></i> Entosis Calculator</a></li>
                            <li><a href="{{ URL::asset('jumpfatigue') }}"><i class="fa fa-calculator"></i> Jump Fatigue Calculator</a></li>
                            <li><a href="{{ URL::asset('indevelopment') }}"><i class="fa fa-sort-alpha-asc"></i> Pastebin</a></li>
                        </ul>
                    </li>

                    @if (Auth::check())
                        <li>
                            <a href={{ URL::asset('dashboard/home') }}>

                                <i class="fa fa-th-large"></i> Dashboard
                            </a>
                        </li>

                    @endif

                    <!-- End Topbar -->

                </ul>

            </div><!--/end container-->
        </div><!--/navbar-collapse-->
    </div>
    <!--=== End Header ===-->
