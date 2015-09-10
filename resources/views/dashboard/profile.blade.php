@extends('dashboard.layouts.mainwithheading')

@section('heading')Profile Settings @endsection
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
    <li class="active">
        <strong>Settings</strong>
    </li>
@endsection

@section('content')


    <div class="row">
        <!-- user details panel -->
        <div class="col-md-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>
                        <b>Change Profile Settings</b>
                    </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>

                </div>
                <div class="ibox-content">

                    {!!   Form::open(array('class' => 'form-horizontal')) !!}
                    <fieldset>

                        <!-- Form Name -->

                        <!-- Select Basic -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="selectbasic">Current Main Character</label>
                            <div class="col-md-4">
                                {!! Form::select('main_character_id', $available_characters, \ineluctable\Services\Settings\SettingHelper::getSetting('main_character_id'), array('class' => 'form-control'))  !!}
                            </div>
                        </div>

                        <!-- Select Basic -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="selectbasic">SeAT Theme</label>
                            <div class="col-md-4">
                                {!! Form::select('color_scheme', array('blue' => 'Blue', 'black' => 'Black'), \ineluctable\Services\Settings\SettingHelper::getSetting('color_scheme'), array('class' => 'form-control'))  !!}
                            </div>
                        </div>

                        <!-- Prepended text-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="prependedtext">Number Format</label>
                            <div class="col-md-6">
                                <div class="form-inline input-group">
                                    100
                                    {!! Form::select('thousand_seperator', array('.' => '.', ',' => ',', ' ' => '(space)'), \ineluctable\Services\Settings\SettingHelper::getSetting('thousand_seperator'), array('class' => 'form-inline form-control')) !!}
                                    000
                                    {!! Form::select('decimal_seperator', array('.' => '.', ',' => ','), \ineluctable\Services\Settings\SettingHelper::getSetting('decimal_seperator'), array('class' => 'form-control')) !!}
                                    00
                                </div>
                                <span class="help-block">Set the thousand and decimal character, e.g: 100,000.00</span>
                            </div>
                        </div>

                        <!-- Select Basic -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="selectbasic">Email Notifications</label>
                            <div class="col-md-4">
                                {!! Form::select('email_notifications', array('true' => 'Yes', 'false' => 'No'), \ineluctable\Services\Settings\SettingHelper::getSetting('email_notifications'), array('class' => 'form-control')) !!}
                                <span class="help-block">Receive copies of notifications via Email</span>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="singlebutton"></label>
                            <div class="col-md-4">
                                <button id="singlebutton" name="singlebutton" class="btn btn-primary">Save</button>
                            </div>
                        </div>

                    </fieldset>
                    </form>
                </div>

                <div class="ibox-footer">
                    {{ $key_count }} Owned API Keys
                  <span class="pull-right">

                    @if ($user->isSuperUser())
                          <span> Last Login: {{ $user->last_login }} ({{ Carbon\Carbon::parse($user->last_login)->diffForHumans() }}) </span>
                      @endif

                  </span>
                </div>
            </div>
        </div>

        <!-- user details panel -->




    <!-- user details panel -->

        <div class="col-md-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><b>{{ $user->username }} ({{ $user->email }})</b></h5>

                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>

                </div>

                <div class="ibox-content">

                    <div class="row">

                        <div class="col-md-6">
                            <p class="lead small">Account Settings</p>
                            <a data-toggle="modal" data-target="#password-modal"><i class="fa fa-lock"></i> Change Password</a><br>
                            <a data-toggle="modal" data-target="#access-log-modal" id="access-log"><i class="fa fa-th-list"></i> View Account Access Log</a>
                        </div>

                        <div class="col-md-6">
                            <p class="lead small">Group Memberships</p>

                            @foreach($user->groups as $group)

                                <i class="fa fa-fw fa-group"></i>{{ $group->name }}<br>

                            @endforeach

                        </div>
                    </div>
            </div>

            <div class="ibox-footer">
               <span class="label label-Information">Administrator Account</span>
            </div>
        </div>
    </div>

     </div>

    <div class="row">
        <div class="col-md-12">
            <p class="text-center">For any account related enquiries, including permissions amendments, please contact your administrator.</p>
        </div>
    </div>

    <!-- password reveal modal -->
    <div class="modal inmodal fade" id="password-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-lock"></i> Change Password</h4>
                </div>
                <div class="modal-body">
                    {!!   Form::open(array('action' => 'ProfileController@postChangePassword', 'class' => 'form-horizontal')) !!}
                    <fieldset>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="oldPassword">Old Password</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    {!!   Form::password('oldPassword', array('id' => 'oldPassword', 'class' => 'form-control'), 'required', 'autofocus') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="newPassword">New Password</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    {!! Form::password('newPassword', array('id' => 'newPassword', 'class' => ' form-control'), 'required') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="confirmPassword">Confirm Password</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    {!!  Form::password('newPassword_confirmation', array('id' => 'confirmPassword', 'class' => ' form-control'), 'required')  !!}
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                  <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>

                    </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- account access-log modal modal -->
    <div class="modal inmodal fade" id="access-log-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-th-list"></i> View Account Access Log</h4>
                </div>
                <div class="modal-body">
                    <span id="log-render"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->

        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection

@section('scripts')
    <script type="text/javascript">

        // Bind a listener to the tabs which should load the required ajax for the
        // tab that is selected
        $("a#access-log").click(function() {

            console.log('aaai');

            // Populate the tab based on the url in locations
            $('span#log-render')
                    .html('<br><p class="lead text-center"><i class="fa fa-cog fa fa-spin"></i> Loading the request...</p>')
                    .load("{{ action('ProfileController@getAccessLog')}}");

        });

    </script>

@endsection