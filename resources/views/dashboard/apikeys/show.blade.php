@extends('dashboard.layouts.mainwithheading')

@section('heading')API Key Details @endsection
@section('breadcrumbs')
    <li>
        <a href="{{ URL::asset('/home') }}">Home</a>
    </li>
    <li>
        <a href="{{ URL::asset('dashboard/home') }}">Dashboard</a>
    </li>
    <li>
        <a>Profile</a>
    </li>
    <li>
        <a href="{{ URL::asset('dashboard/apikeys') }}">API Keys</a>
    </li>
    <li class="active">
        <strong>API Key Details</strong>
    </li>
@endsection



@section('content')

    <div class="row">

        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <a class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#vcode-modal"><i class="fa fa-circle-o"></i> Reveal vCode</a>
                    <h5>Key ID</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ $key_information->keyID }}</h1>
                </div>
            </div>
        </div>


        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Key Type</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">
                        @if (strlen($key_information->type) > 0)
                            {{ $key_information->type }}
                        @else
                            Unknown
                        @endif
                    </h1>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Access Mask</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">
                        @if (strlen($key_information->accessMask) > 0)
                            {{ $key_information->accessMask }}
                        @else
                            Unknown
                        @endif
                    </h1>
                </div>
            </div>
        </div>


        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Key Status</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">
                        @if ($key_information->isOk == 1)
                            <span style="color: green"><i class="fa fa-thumbs-up"></i></span> Key is OK
                        @else
                            <span style="color: red"><i class="fa fa-thumbs-down"></i></span> Key has a problem
                        @endif
                    </h1>
                </div>
            </div>
        </div>

    </div>



    <div class="row">

        {{--Characters on key--}}
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Characters on Key</h5>
                </div>
                <div class="ibox-content">
                    @if (count($key_characters) > 0)

                        @foreach ($key_characters as $character)

                            <div class="row">
                                <div class="col-md-4">
                                    <a href="{{ action('CharacterController@show', array('characterID' => $character->characterID )) }}">
                                        <img alt="image" class="img-circle pull-right" src="https://imageserver.eveonline.com/Character/{{$character->characterID}}_64.jpg" />
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    {{--<p class="lead">{{ $character->characterName }}</p>--}}
                                    <h2>{{ $character->characterName }}</h2>
                                    <p>{{ $character->corporationName }}</p>
                                </div>
                            </div>

                        @endforeach

                    @else
                        No known characters on this key
                    @endif
                </div>
            </div>
        </div>

        {{--Key Access Mask Breakdown--}}
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Access Mask Breakdown</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-condensed table-hover">
                        <thead>
                        <tr>
                            <th>Endpoint</th>
                            <th>Access</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach (ineluctable\Services\Helpers\Helpers::processAccessMask($key_information->accessMask, $key_information->type) as $endpoint => $access)

                            <tr>
                                <td>{{ $endpoint }}</td>
                                <td>
                                    @if ($access == 'true')
                                        <span class="text-green">{{ $access }}</span>
                                    @else
                                        <span class="text-red">{{ $access }}</span>
                                    @endif
                                </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        @if(Auth::isSuperUser())


            <div class="col-lg-4">

                {{--Key Ownership--}}
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Key Ownership</h5>
                    </div>
                    <div class="ibox-content">
                        <ul class="list-unstyled">

                            @foreach($key_owner as $owner)


                                <li><a href="{{ action('UserController@edit', array('userID' => $owner->id))  }}"><i class="fa fa-user"></i> {{ $owner->username }}</a> ({{ $owner->email }})</li>

                            @endforeach

                        </ul>
                    </div>
                    <div class="ibox-footer">
                        <a id="transfer" data-toggle="modal" data-target="#TransferOwnershipModal" class="btn btn-primary btn-xs">Transfer Key Ownership</a>
                    </div>
                </div>


            {{--Banned Calls--}}
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Banned Calls</h5>
                    </div>
                    <div class="ibox-content">
                        @if (count($key_bans) > 0)
                            <table class="table table-condensed table-hover">
                                <thead>
                                <tr>
                                    <th>Scheduled</th>
                                    <th>Access Mask</th>
                                    <th>API</th>
                                    <th>Scope</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($key_bans as $ban)

                                    <tr>
                                        <td>
                      <span data-toggle="tooltip" title="" data-original-title="{{ $ban->created_at }}">
                        {{ Carbon\Carbon::parse($ban->created_at)->diffForHumans() }}
                      </span>
                                        </td>
                                        <td>{{ $ban->accessMask }}</td>
                                        <td>{{ $ban->api }}</td>
                                        <td>{{ $ban->scope }}</td>
                                        <td>
                                            @if (strlen($ban->reason) > 0)
                                                <i class="fa fa-bullhorn pull-right" data-container="body" data-toggle="popover" data-placement="top" data-content="{{ $ban->reason }}" data-trigger="hover"></i>
                                            @endif
                                        </td>
                                        <td><i class="fa fa-times" id="remove-ban" a-ban-id="{{ $ban->id }}" data-toggle="tooltip" title="" data-original-title="Remove Ban"></i></td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>

                        @else
                            No banned calls for this key
                        @endif
                    </div>
                </div>
            </div>

        @endif

    </div>


    <div class="modal inmodal" id="TransferOwnershipModal" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-exchange modal-icon"></i>
                    <h4 class="modal-title">Transfer Ownership</h4>
                    <small class="font-bold">Move key to another user</small>
                </div>
                <form class="form-horizontal" method="post" action="{{ action('ApiKeyController@TransferOwnership') }}">
                    <div class="modal-body">
                        <p>Select the user that you would like to transfer ownership to:</p>
                        <div class="row">
                            <div class="col-lg-12">
                                <select class="form-control" id="accountid" name="accountid">
                                    @foreach($userlist as $user)
                                        <option value="{{$user->id}}">{{$user->username}} : {{$user->email}}</option>
                                    @endforeach
                                </select>

                                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                                <input type="hidden" name="keyID" id="keyID" value="{{ $key_information->keyID }}" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                        <input type="submit" value="Transfer Ownership" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

@endsection