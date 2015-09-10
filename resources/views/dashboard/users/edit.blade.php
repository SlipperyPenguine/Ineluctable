@extends('dashboard.layouts.mainwithheading')

@section('heading')API Keys @endsection
@section('breadcrumbs')
    <li>
        <a href="{{ URL::asset('/home') }}">Home</a>
    </li>
    <li>
        <a href="{{ URL::asset('dashboard/home') }}">Dashboard</a>
    </li>
    <li>
        <a>Configuration</a>
    </li>
    <li>
        <a href="{{ URL::asset('dashboard/users') }}">Users</a>
    </li>
    <li class="active">
        <strong>User Details</strong>
    </li>
@endsection

@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>User Details</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">

            {!! Form::open(array('action' => 'UserController@update', 'method' => 'PUT', 'class' => 'form-horizontal')) !!}
            {!! Form::hidden('userID', $user->getKey()) !!}
            <fieldset>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="email">Email Address</label>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            {!! Form::text('email', $user->email, array('id' => 'email', 'class' => 'form-control', 'placeholder' => 'Email Address'), 'required', 'autofocus') !!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="username">Username</label>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            {!! Form::text('username', $user->username, array('id' => 'email', 'class' => 'form-control', 'placeholder' => 'Username'), 'required') !!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="password">Password</label>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-magic"></i></span>
                            {!! Form::password('password', array('id' => 'password', 'class' => ' form-control', 'placeholder' => 'Password'), 'required') !!}
                        </div>
                    </div>
                </div>

                @foreach ($availableGroups as $availableGroup)

                    <div class="form-group">
                        <label class="col-md-6 control-label" for="singlebutton">{{ $availableGroup->name }}</label>
                        <div class="form-group">
                            {!! Form::checkbox($availableGroup->name, '1', (isset($hasGroups[$availableGroup->name]) ? true : false)) !!}
                        </div>
                    </div>

                    @endforeach

                            <!-- Button -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="singlebutton"></label>
                        <div class="col-md-4">
                            {!! Form::submit('Update User', array('class' => 'btn btn-primary btn-block')) !!}
                        </div>
                    </div>

            </fieldset>
            {!! Form::close() !!}

        </div>
    <div class="ibox-footer">
        footer here
    </div>


@endsection

@section('scripts')

        <!-- Page-Level Scripts -->
        <script>
            $(document).ready(function() {
                $('.dataTables-users').dataTable({
                    responsive: true,
                    "dom": 'T<"clear">lfrtip',
                    "tableTools": {
                        "sSwfPath": "{{ URL::asset('js/plugins/dataTables/swf/copy_csv_xls_pdf.swf') }}"
                    }
                });

            });

        </script>


@endsection