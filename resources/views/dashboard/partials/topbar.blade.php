<div class="row border-bottom">
    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" method="post" action="#">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-envelope"></i> @if($unreadmails>0) <span class="label label-warning">{{$unreadmails}}</span> @endif
                </a>
                <ul class="dropdown-menu dropdown-messages">
                    @if($recentmails)
                    @foreach($recentmails as $mail)
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="https://image.eveonline.com/Character/{{$mail->message->senderID}}_32.jpg" />
                                </a>
                                <div class="media-body">
                                    <a href="{{ action('MailController@show', ['id' => $mail->messageID])}}" class="topmail" ><strong>{{$mail->message->title}}</strong></a> <br>
                                    <small class="text-muted">{{$mail->message->sentDate->diffForHumans()}} ago at {{$mail->message->sentDate}}</small>
                                </div>
                            </div>
                        </li>

                        <li class="divider"></li>

                    @endforeach
                    @endif

                    <li>
                        <div class="text-center link-block">
                            <a href="{{URL::asset('dashboard/mail')}}">
                                <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ URL::asset('auth/logout') }}">
                    <i class="fa fa-sign-out"></i> Log out
                </a>
            </li>
            <li>
                <a class="right-sidebar-toggle">
                    <i class="fa fa-tasks"></i>
                </a>
            </li>

        </ul>




        <div id="right-sidebar">
            <div class="sidebar-container">

                <ul class="nav nav-tabs navs-3">

                    <li class="active"><a data-toggle="tab" href="#tab-1">
                            Characters
                        </a></li>
                    <li><a data-toggle="tab" href="#tab-2">
                            Corps
                        </a></li>
                    <li class=""><a data-toggle="tab" href="#tab-3">
                            <i class="fa fa-gear"></i>
                        </a></li>
                </ul>

                <div class="tab-content">


                    <div id="tab-1" class="tab-pane active">

                        <div class="sidebar-title">
                            <h3> <i class="fa fa-user"></i> Characters</h3>
                            <small><i class="fa fa-tim"></i> You have {{$characters->count()}} characters registered</small>
                        </div>

                        <div>
                            @if($characters->count() > 0)

                                @foreach($characters as $character)

                                    <div class="sidebar-message">
                                        <a href="{{ URL::asset('dashboard/characters/') }}/{{$character->characterID}}">
                                            <div class="row">
                                                    <div class="col-md-4">
                                                        <img alt="image" class="img-circle" height="48px" src="https://image.eveonline.com/Character/{{$character->characterID}}_64.jpg" />
                                                    </div>
                                                    <div class="col-md-8">
                                                        <strong>{{$character->characterName}}</strong> <br/>
                                                        <small>{{$character->corporationName}}</small> <br/>
                                                        <small>{{$character->characterInfo->lastKnownLocation}} - {{$character->characterInfo->shipTypeName}}</small>
                                                    </div>
                                            </div>
                                        </a>
                                    </div>


                                @endforeach

                            @else

                                <div class="sidebar-message">
                                    <a href="{{ URL::asset('dashboard/apikeys/create') }}">
                                        <div class="row">
                                            You have no characters registered.  Click here to add an API key to your account
                                        </div>
                                    </a>
                                </div>
                            @endif

                        </div>

                    </div>

                    <div id="tab-2" class="tab-pane">

                        <div class="sidebar-title">
                            <h3> <i class="fa fa-university"></i> Corporations</h3>
                            <small><i class="fa fa-tim"></i> You have {{$corporations->count()}} corporations registered</small>
                        </div>

                        <div>
                            @if($corporations->count() > 0)

                                @foreach($corporations as $corporation)

                                    <div class="sidebar-message">
                                        <a href="{{ URL::asset('dashboard/characters/') }}/{{$corporation->characterID}}">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <img alt="image" class="img-circle" height="48px" src="https://image.eveonline.com/Corporation/{{$corporation->corporationID}}_64.png" />
                                                </div>
                                                <div class="col-md-8">
                                                    <strong>{{$corporation->corporationName}}</strong>
                                                </div>
                                            </div>
                                        </a>
                                    </div>


                                @endforeach

                            @else

                                <div class="sidebar-message">
                                    <a href="{{ URL::asset('dashboard/apikeys/create') }}">
                                        <div class="row">
                                            You have no corporations registered.  Click here to add an API key to your account
                                        </div>
                                    </a>
                                </div>
                            @endif

                        </div>

                    </div>

                    <div id="tab-3" class="tab-pane">

                        <div class="sidebar-title">
                            <h3><i class="fa fa-gears"></i> Settings</h3>
                            <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
                        </div>

                        <div class="setings-item">
                    <span>
                        Show notifications
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example">
                                    <label class="onoffswitch-label" for="example">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                    <span>
                        Disable Chat
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" checked class="onoffswitch-checkbox" id="example2">
                                    <label class="onoffswitch-label" for="example2">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                    <span>
                        Enable history
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example3">
                                    <label class="onoffswitch-label" for="example3">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                    <span>
                        Show charts
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example4">
                                    <label class="onoffswitch-label" for="example4">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                    <span>
                        Offline users
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox" id="example5">
                                    <label class="onoffswitch-label" for="example5">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                    <span>
                        Global search
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox" id="example6">
                                    <label class="onoffswitch-label" for="example6">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                    <span>
                        Update everyday
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example7">
                                    <label class="onoffswitch-label" for="example7">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-content">
                            <h4>Settings</h4>
                            <div class="small">
                                I belive that. Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                And typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                            </div>
                        </div>

                    </div>
                </div>

            </div>



        </div>


</nav>
</div>

