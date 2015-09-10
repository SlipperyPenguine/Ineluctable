<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span>
                            <img alt="image" class="img-circle" src="https://imageserver.eveonline.com/Character/{{\ineluctable\Services\Settings\SettingHelper::getSetting('main_character_id')}}_64.jpg" />
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{Auth::user()->username}}  <b class="caret"></b></strong>
                             </span>  </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{ URL::asset('dashboard/profile') }}">Settings</a></li>
                        <li><a href="{{ URL::asset('auth/logout') }}">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    NOWAY
                </div>
            </li>
            <li @if(str_contains($controller,'DashboardController') && str_contains($action,'home') )class="active" @endif>
                <a href="{{ URL::asset('dashboard/home') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
            </li>

            <li @if( preg_match("(CharacterController|MailController|AssetController)", $controller))class="active" class="active" @endif>
                <a href="{{ URL::asset('dashboard/characters') }}"><i class="fa fa-users"></i> <span class="nav-label">Characters</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li @if(str_contains($controller,'CharacterController') && str_contains($action,'index'))class="active" @endif><a href="{{ URL::asset('dashboard/characters') }}">Character List</a></li>
                </ul>
                <ul class="nav nav-second-level collapse">
                    <li @if(str_contains($controller,'MailController') && str_contains($action,'index'))class="active" @endif><a href="{{ URL::asset('dashboard/mail') }}">Inbox</a></li>
                </ul>
                <ul class="nav nav-second-level collapse">
                    <li @if(str_contains($controller,'AssetController') && str_contains($action,'SearchAllAssets'))class="active" @endif><a href="{{ URL::asset('dashboard/assets/searchassets') }}">Assets</a></li>
                </ul>
            </li>


            <li @if(str_contains($controller,'ProfileController'))class="active" @elseif(str_contains($controller,'ApiKeyController'))class="active" @endif>
                <a href="{{ URL::asset('dashboard/profile') }}"><i class="fa fa-cogs"></i> <span class="nav-label">Profile</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li @if(str_contains($action,'showProfile'))class="active" @endif><a href="{{ URL::asset('dashboard/profile') }}">Profile Settings</a></li>
                    <li @if(str_contains($controller,'ApiKeyController') && str_contains($action,'index'))class="active" @endif><a href="{{ URL::asset('dashboard/apikeys') }}">API Keys</a></li>
                </ul>
            </li>

            <li @if(str_contains($controller,'DebugController'))class="active" @endif>
                <a href="{{ URL::asset('dashboard/debug/api') }}"><i class="fa fa-bug"></i> <span class="nav-label">Debug</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li @if(str_contains($action,'DashboardGetApi'))class="active" @endif><a href="{{ URL::asset('dashboard/debug/api') }}">API Check</a></li>
                    <li @if(str_contains($action,'browser'))class="active" @endif><a href="{{ URL::asset('dashboard/debug/browser') }}">Browser Check</a></li>
                    <li @if(str_contains($action,'logfiles'))class="active" @endif><a href="{{ URL::asset('dashboard/debug/logfiles') }}">View Log Files</a></li>
                    <li @if(str_contains($action,'jobs'))class="active" @endif><a href="{{ URL::asset('dashboard/debug/jobs') }}">View Jobs</a></li>

                </ul>
            </li>

            @if(Auth::isSuperUser())
                <li @if(str_contains($controller,'UserController'))class="active" @endif>
                    <a href="{{ URL::asset('dashboard/users') }}"><i class="fa fa-wrench"></i> <span class="nav-label">Configuration</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li @if(str_contains($controller,'UserController') && str_contains($action,'index'))class="active" @endif><a href="{{ URL::asset('dashboard/users') }}">Users</a></li>
                    </ul>
                </li>
            @endif

            <li>
                <a href="{{ URL::asset('/home') }}"><i class="fa fa-home"></i> <span class="nav-label">Return to main site</span></a>
            </li>

        </ul>

    </div>
</nav>

