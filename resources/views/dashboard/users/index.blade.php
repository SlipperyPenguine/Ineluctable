@extends('dashboard.layouts.mainwithheading')

@section('heading')Users @endsection
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
    <li class="active">
        <strong>Users</strong>
    </li>
@endsection

@section('content')

    <div class="row">
        <!-- Existing users panel -->
        <div class="col-md-8">

             <div class="ibox float-e-margins">

                 <div class="ibox-title">
                    <h5>Existing Users</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                 <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-users" >
                    <thead>
                    <tr>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Last Login</th>
                        <th>Administrator</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($users as $user)

                        <tr>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->username }}</td>
                            <td>
                    <span data-toggle="tooltip" title="" data-original-title="{{ $user->last_login }}">
                      {{ Carbon\Carbon::parse($user->last_login)->diffForHumans() }}
                    </span>
                            </td>
                            <td>{!!   \Auth::isSuperUser($user) ? "<span class='text-red'>Yes</span>" : "No" !!}</td>
                            <td>

                                <a href="{{ action('UserController@edit', array('userID' => $user->getKey())) }}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                                @if (count($users) > 1 && $user->getKey() != \Auth::User()->id)
{{--                                    <form style="display: inline;" method="POST" action="{{  action('UserController@destroy', array('userID' => $user->getKey())) }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-danger btn-xs delete-user" value="Delete">
                                    </form>--}}
                                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-userid="{{$user->getKey()}}" data-username="{{$user->username}}" data-email="{{$user->email}}" data-target="#DeleteModal">
                                        <i class="fa fa-times"></i> Delete
                                    </button>

                                    <a href="{{ action('UserController@Impersonate', array('userID' => $user->getKey())) }}" class="pull-right btn btn-success btn-xs" data-container="body" data-toggle="popover" data-placement="left" data-content="Note: To return to the admin view, you will have to re-login after impersonation" data-trigger="hover">Impersonate</a>
                                @endif
                            </td>
                        </tr>

                    @endforeach

                    </tbody>

                </table>
            </div>

        </div>




            </div>
        </div>

        <!-- Add a user panel -->
        <div class="col-md-4">

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Add a User</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                 <div class="ibox-content">

                     {!! Form::open(array('id' => 'AddUser', 'action' => 'UserController@store', 'class' => 'form-horizontal')) !!}
                     <fieldset>

                         <div class="form-group">
                             <label class="col-md-4 control-label" for="email">Email Address</label>
                             <div class="col-md-6">
                                 <div class="input-group">
                                     <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                     <input id="email" class="form-control" placeholder="Email Address" type="email" name="email" required autofocus>
                                 </div>
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="col-md-4 control-label" for="username">Username</label>
                             <div class="col-md-6">
                                 <div class="input-group">
                                     <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                     <input id="username" class="form-control" placeholder="Username" name="username" type="text" minlength="3" required>

                                 </div>
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="col-md-4 control-label" for="password">Password</label>
                             <div class="col-md-6">
                                 <div class="input-group">
                                     <span class="input-group-addon"><i class="fa fa-magic"></i></span>
                                     <input id="password" class=" form-control" placeholder="Password" name="password" type="password" value="" minlength="6" required>
                                 </div>
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="col-md-4 control-label" for="password">Password Again</label>
                             <div class="col-md-6">
                                 <div class="input-group">
                                     <span class="input-group-addon"><i class="fa fa-magic"></i></span>
                                     <input id="password_confirmation" class=" form-control" placeholder="Password Again" name="password_confirmation" type="password" value="" minlength="6" required>
                                 </div>
                             </div>
                         </div>

                         <div class="form-group">
                             <label class="col-md-4 control-label" for="is_admin">Superuser?</label>
                             <div class="col-md-6">
                                 <div class="input-group">
                                     {!! Form::checkbox('is_admin', 'yes') !!}
                                 </div>
                             </div>
                         </div>

                         <!-- Button -->
                         <div class="form-group">
                             <label class="col-md-4 control-label" for="singlebutton"></label>
                             <div class="col-md-6">
                                 {!! Form::submit('Add User', array('class' => 'btn bg-olive btn-block')) !!}
                             </div>
                         </div>

                     </fieldset>
                     {!! Form::close() !!}


                 </div>
            </div>

        </div>
    </div>


    <div class="modal inmodal" id="DeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-eraser modal-icon"></i>
                    <h4 class="modal-title">Delete User</h4>
                </div>
                <div class="modal-body">
                    <p>Please confirm you would like to delete this user</p>
                    <div><strong>User ID:</strong> <span id="modalUserID">HERE</span></div>
                    <div><strong>User Name:</strong> <span id="modalUserName">HERE</span></div>
                    <div><strong>Email:</strong> <span id="modalUserEmail">HERE</span></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                    <button id="deleteuserconfirmed" type="button" class="btn btn-danger">Delete User</button>
                </div>
            </div>
        </div>
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

    <script>

        $( "#AddUser" ).validate({
            rules: {
                password: "required",
                password_confirmation: {
                    equalTo: "#password"
                }
            }
        });

        //triggered when modal is about to be shown
        $('#DeleteModal').on('show.bs.modal', function(e) {

            //get data-id attribute of the clicked element
            var userid = $(e.relatedTarget).data('userid');
            var username = $(e.relatedTarget).data('username');
            var useremail = $(e.relatedTarget).data('email');

            $('#modalUserID').text(userid);
            $('#modalUserName').text(username);
            $('#modalUserEmail').text(useremail);



            //populate the textbox
            /*$(e.currentTarget).find('input[name="buttonid"]').val(ButtonID);*/
        });


        $( "#deleteuserconfirmed" ).click(function() {
            //alert( "Delete user confirmed" );
            var userid = $('#modalUserID').text();
            var route = "{{ route('dashboard.users.index')}}";

            //create the form and submit it
            var form = document.createElement("form");
            form.setAttribute("method", "post");
            form.setAttribute("action", route);


            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "_method");
            hiddenField.setAttribute("value", "DELETE");
            form.appendChild(hiddenField);

            hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "_token");
            hiddenField.setAttribute("value", "{{ csrf_token() }}");
            form.appendChild(hiddenField);

/*            hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", "id");
            hiddenField.setAttribute("value", userid);
            form.appendChild(hiddenField);*/

            document.body.appendChild(form);
            form.submit();
        });
    </script>


@endsection