@extends('dashboard.layouts.mainwithheading')

@section('heading')Character Details - {{$character->characterName}} @endsection
@section('breadcrumbs')
    <li>
        <a href="{{ URL::asset('/home') }}">Home</a>
    </li>
    <li>
        <a href="{{ URL::asset('dashboard/home') }}">Dashboard</a>
    </li>
    <li>
        <a href="{{ URL::asset('dashboard/characters') }}">Characters</a>
    </li>
    <li class="active">
        <strong>Character Details</strong>
    </li>
@endsection

@section('header')

    {{--override the tab style--}}
    <style>
        .tabs-container .tabs-left .panel-body {
            width: 80%;
            margin-left: 200px; }
    </style>

@endsection

@section('content')

    {{-- character information --}}
    <div class="row">
        <div class="col-md-4">
            <div class="ibox">
                <div class="ibox-content">
                    <p class="text-center">
                        {!! ineluctable\Services\Helpers\Img::character($character->characterID, 256) !!}
                    </p>
                    <p class="text-center lead">{{ $character->characterName }}</p>
                </div><!-- /.box-body -->
                <div class="box-footer text-center">
                    <a target="_blank" title="View {{ $character->characterName }} on EVEBoard" data-toggle="tooltip" href="http://eveboard.com/pilot/{{ $character->characterName }}" >
                        <img src='{{ URL::asset('assets/img/eveboard.png') }}' />
                    </a>
                    <a target="_blank" title="View {{ $character->characterName }} on EVE Gate" data-toggle="tooltip" href="https://gate.eveonline.com/Profile/{{ $character->characterName }}" >
                        <img src='{{ URL::asset('assets/img/evegate.png') }}' />
                    </a>
                    <a target="_blank" title="View {{ $character->characterName }} on EVE-Kill" data-toggle="tooltip" href="https://eve-kill.net/?a=pilot_detail&plt_external_id={{ $character->characterID }}" >
                        <img src='{{ URL::asset('assets/img/evekill.png') }}' />
                    </a>
                    <a target="_blank" title="View {{ $character->characterName }} on EVE-Search" data-toggle="tooltip" href="http://eve-search.com/search/author/{{ $character->characterName }}" >
                        <img src='{{ URL::asset('assets/img/evesearch.png') }}' />
                    </a>
                    <a target="_blank" title="View {{ $character->characterName }} on EVE WHO" data-toggle="tooltip" href="http://evewho.com/pilot/{{ $character->characterName }}" >
                        <img src='{{ URL::asset('assets/img/evewho.png') }}' />
                    </a>
                    <a target="_blank" title="View {{ $character->characterName }} on zKillboard" data-toggle="tooltip" href="https://zkillboard.com/character/{{ $character->characterID }}/" >
                        <img src='{{ URL::asset('assets/img/zkillboard.png') }}' />
                    </a>
                </div>
            </div><!-- ./box -->
        </div>
        <div class="col-md-4">
            <div class="ibox">
                <div class="ibox-content">
                    @if (count($other_characters) > 0)

                        @foreach ($other_characters as $alt)

                            <div class="row">
                                <a href="{{ action('CharacterController@show', array('characterID' => $alt->characterID )) }}" style="color:inherit;">
                                    <div class="col-md-4">
                                        {!! ineluctable\Services\Helpers\Img::character($alt->characterID, 64, true) !!}
                                    </div>
                                    <div class="col-md-8">
                                        <ul class="list-unstyled">
                                            <li><b>Name: </b>{{ $alt->characterName }}</li>
                                            <li><b>Corp: </b>{{ $alt->corporationName }}</li>
                                            <li>
                                                @if (strlen($alt->trainingEndTime) > 0)
                                                    <b>Training Ends: </b> {{ Carbon\Carbon::parse($alt->trainingEndTime)->diffForHumans() }}
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </a>
                            </div><!-- ./row -->

                        @endforeach

                    @else
                        No other known characters on this key.
                    @endif

                </div><!-- /.box-body -->
                <div class="ibox-footer">
                    <p class="text-center lead">{{ count($other_characters) }} other characters on this API Key</p>
                </div><!-- /.box-footer-->
            </div><!-- ./box -->
        </div>
        <div class="col-md-4">
            <div class="ibox">
                <div class="ibox-content">
                    @if (count($people) > 0)
                        <div class="row">

                            @foreach (array_chunk($people, (count($people) / 2) > 1 ? count($people) / 2 : 2) as $other_alts)

                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        @foreach ($other_alts as $person)
                                            <li>
                                                <a href="{{ action('CharacterController@getView', array('characterID' => $person->characterID)) }}">
                                                    <img alt="image" class="img-circle" src="https://imageserver.eveonline.com/Character/{{$person->characterID}}_16.jpg" />

                                                    {{ $person->characterName }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                            @endforeach

                        </div> <!-- ./row -->
                    @else
                        No characters in a person group
                    @endif

                </div><!-- /.box-body -->
                <div class="ibox-footer">
                    <p class="text-center lead">{{ count($people) }} characters on this people group</p>
                </div><!-- /.box-footer-->
            </div><!-- ./box -->
        </div>
    </div>


    <div class="row m-t-lg">
        <div class="col-lg-12">
            <div class="tabs-container">
                <div class="tabs-left">
                    <ul class="nav nav-tabs" style="width: 200px;">
                        <li class="active"><a id="load-tab" data-toggle="tab" href="#character_sheet"> Character Sheet</a></li>
                        <li><a id="load-tab" data-toggle="tab" href="#character_skills">Skills</a></li>
                        <li><a id="load-tab" href="#wallet_journal" data-toggle="tab">Wallet Journal</a></li>
                        <li><a id="load-tab" href="#wallet_transactions" data-toggle="tab">Wallet Transactions</a></li>
                        <li><a id="load-tab" href="#mail" data-toggle="tab" >Mail</a></li>
                        <li><a id="load-tab" href="#notifications" data-toggle="tab" >Notifications</a></li>
                        <li><a id="load-tab" href="#assets" data-toggle="tab" >Assets</a></li>
                        <li><a id="load-tab" href="#industry" data-toggle="tab" >Industry</a></li>
                        <li><a id="load-tab" href="#contacts" data-toggle="tab" >Contacts</a></li>
                        <li><a id="load-tab" href="#contracts" data-toggle="tab" >Contracts</a></li>
                        <li><a id="load-tab" href="#market_orders" data-toggle="tab" >Market Orders</a></li>
                        <li><a id="load-tab" href="#calendar_events" data-toggle="tab" >Calendar Events</a></li>
                        <li><a id="load-tab" href="#character_standings" data-toggle="tab">Standings</a></li>
                        <li><a id="load-tab" href="#killmails" data-toggle="tab" >Kill Mails</a></li>
                        <li><a id="load-tab" href="#character_research" data-toggle="tab">Research Agents</a></li>
                        <li><a id="load-tab" href="#character_pi" data-toggle="tab">Planetary Interaction</a></li>
                    </ul>
                    <div class="tab-content ">
                        <div id="character_sheet" class="tab-pane active">
                            <div class="panel-body">
                                <div id="tabresults_character_sheet">NOTLOADED</div>
                            </div>
                        </div>
                        <div id="character_skills" class="tab-pane">
                            <div class="panel-body">
                                <div id="tabresults_character_skills">NOTLOADED</div>
                            </div>
                        </div>

                        <div id="wallet_journal" class="tab-pane">
                            <div class="panel-body">
                                <div id="tabresults_wallet_journal">NOTLOADED</div>
                            </div>
                        </div>

                        <div id="wallet_transactions" class="tab-pane">
                            <div class="panel-body">
                                <div id="tabresults_wallet_transactions">NOTLOADED</div>
                            </div>
                        </div>

                        <div id="mail" class="tab-pane">
                            <div class="panel-body">
                                <div id="tabresults_mail">NOTLOADED</div>
                            </div>
                        </div>

                        <div id="notifications" class="tab-pane">
                            <div class="panel-body">
                                <div id="tabresults_notifications">NOTLOADED</div>
                            </div>
                        </div>

                        <div id="assets" class="tab-pane">
                            <div class="panel-body">
                                <div id="tabresults_assets">NOTLOADED</div>
                            </div>
                        </div>

                        <div id="industry" class="tab-pane">
                            <div class="panel-body">
                                <div id="tabresults_industry">NOTLOADED</div>
                            </div>
                        </div>

                        <div id="contacts" class="tab-pane">
                            <div class="panel-body">
                                <div id="tabresults_contacts">NOTLOADED</div>
                            </div>
                        </div>

                        <div id="contracts" class="tab-pane">
                            <div class="panel-body">
                                <div id="tabresults_contracts">NOTLOADED</div>
                            </div>
                        </div>

                        <div id="market_orders" class="tab-pane">
                            <div class="panel-body">
                                <div id="tabresults_market_orders">NOTLOADED</div>
                            </div>
                        </div>

                        <div id="calendar_events" class="tab-pane">
                            <div class="panel-body">
                                <div id="tabresults_calendar_events">NOTLOADED</div>
                            </div>
                        </div>

                        <div id="character_standings" class="tab-pane">
                            <div class="panel-body">
                                <div id="tabresults_character_standings">NOTLOADED</div>
                            </div>
                        </div>

                        <div id="killmails" class="tab-pane">
                            <div class="panel-body">
                                <div id="tabresults_killmails">NOTLOADED</div>
                            </div>
                        </div>

                        <div id="character_research" class="tab-pane">
                            <div class="panel-body">
                                <div id="tabresults_character_research">NOTLOADED</div>
                            </div>
                        </div>

                        <div id="character_pi" class="tab-pane">
                            <div class="panel-body">
                                <div id="tabresults_character_pi">NOTLOADED</div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>



@endsection



@section('scripts')

    <script type="text/javascript">

        $("a#load-tab").click(function() {

            // Tab Ajax Locations are defined here
            var locations = {
                "character_sheet" : "{{ action('CharacterController@getAjaxCharacterSheet', array('characterID' => $character->characterID)) }}",
                "character_skills" : "{{ action('CharacterController@getAjaxSkills', array('characterID' => $character->characterID)) }}",
                "wallet_journal" : "{{ action('CharacterController@getAjaxWalletJournal', array('characterID' => $character->characterID)) }}",
                "wallet_transactions" : "{{ action('CharacterController@getAjaxWalletTransactions', array('characterID' => $character->characterID)) }}",
                "mail" : "{{ action('CharacterController@getAjaxMail', array('characterID' => $character->characterID)) }}",
                "notifications" : "{{ action('CharacterController@getAjaxNotifications', array('characterID' => $character->characterID)) }}",
                "assets" : "{{ action('CharacterController@getAjaxAssets', array('characterID' => $character->characterID)) }}",
                "industry" : "{{ action('CharacterController@getAjaxIndustry', array('characterID' => $character->characterID)) }}",
                "contacts" : "{{ action('CharacterController@getAjaxContacts', array('characterID' => $character->characterID)) }}",
                "contracts" : "{{ action('CharacterController@getAjaxContracts', array('characterID' => $character->characterID)) }}",
                "market_orders" : "{{ action('CharacterController@getAjaxMarketOrders', array('characterID' => $character->characterID)) }}",
                "calendar_events" : "{{ action('CharacterController@getAjaxCalendarEvents', array('characterID' => $character->characterID)) }}",
                "character_standings" : "{{ action('CharacterController@getAjaxStandings', array('characterID' => $character->characterID)) }}",
                "killmails" : "{{ action('CharacterController@getAjaxKillMails', array('characterID' => $character->characterID)) }}",
                "character_research" : "{{ action('CharacterController@getAjaxResearchAgents', array('characterID' => $character->characterID)) }}",
                "character_pi" : "{{ action('CharacterController@getAjaxPlanetaryInteraction', array('characterID' => $character->characterID)) }}"
            }

            var tabname = $(this).attr("href").replace('#','');
            var divname = 'div#tabresults_'+tabname;

            if( $(divname).text()=="NOTLOADED") {

                //alert(tabname);

                $(divname)
                        .html('<br><p class="lead text-center"><i class="fa fa-cog fa fa-spin"></i> Loading the request...</p>')
                        .load(locations[tabname]);

            }

        });

        $( document ).ready(function() {
            $('div#tabresults_character_sheet')
                    .html('<br><p class="lead text-center"><i class="fa fa-cog fa fa-spin"></i> Loading the request...</p>')
                    .load("{{ action('CharacterController@getAjaxCharacterSheet', array('characterID' => $character->characterID)) }}");
        });


        // Events to be triggered when the ajax calls have compelted.
        $( document ).ajaxComplete(function() {

            // Update any outstanding id-to-name fields
            var items = [];
            var arrays = [], size = 250;

            $('[rel="id-to-name"]').each( function(){
                //add item to array
                if ($.isNumeric($(this).text())) {
                    items.push( $(this).text() );
                }
            });

            items = $.unique( items );

            while (items.length > 0)
                arrays.push(items.splice(0, size));

            $.each(arrays, function( index, value ) {

                $.ajax({
                    type: 'POST',
                    url: "{{ action('HelperController@postResolveNames') }}",
                    data: {
                        '_token' : '{{Session::token()}}',
                        'ids': value.join(',')
                    },
                    success: function(result){
                        $.each(result, function(id, name) {

                            $("span:contains('" + id + "')").html(name);
                        })
                    },
                    error: function(xhr, textStatus, errorThrown){
                        console.log(xhr);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
            });
        });


        // Bind events to the HTML that we will be getting from the AJAX response
        $("div#tabresults_contracts").delegate('.viewcontent', 'click', function() {

            // Expandable assets & contracts views

            // get the tag direct after the button

            var contents = $(this).closest( "table").next( "div" );

           // Show or hide
            contents.toggle();
            $(".img-lazy-load").unveil();
            //setupLazyLoader(contents);

            // some code for stylish
            if (contents.is(":visible")){
                $(this).removeClass('fa-plus').addClass('fa-minus');
                $(this).closest("tr").css( "background-color", "#EBEBEB" ); // change the background color of container (for easy see where we are)
                contents.css( "background-color", "#EBEBEB" ); // change the background color of content (for easy see where we are)
            } else {
                $(this).removeClass('fa-minus').addClass('fa-plus');
                $(this).closest("tr").css( "background-color", "#FFFFFF" ); // reset the background color on container when we hide content
            }
        });

    </script>

@endsection