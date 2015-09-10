@extends('dashboard.layouts.mainwithheading')

@section('heading')@if(isset($title)){{$title}} @elseif(isset($selectedcharacter))Mail Messages For {{$selectedcharacter}} @else Mail Messages @endif @endsection

@section('breadcrumbs')
    <li>
        <a href="{{ URL::asset('/home') }}">Home</a>
    </li>
    <li>
        <a href="{{ URL::asset('dashboard/home') }}">Dashboard</a>
    </li>
    <li class="active">
        <strong>Mail Messages</strong>
    </li>
@endsection

@section('content')

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content mailbox-content">
                        <div class="file-manager">
                            <h5>Views</h5>
                            <ul class="folder-list m-b-md" style="padding: 0">
                                <li><a href="{{ action('MailController@index')}}"> <i class="fa fa-inbox "></i> Inbox @if($unreadcount>0) <span class="label label-warning pull-right">{{$unreadcount}}</span> @endif </a></li>
                                <li><a href="{{ action('MailController@getUnreadMail')}}"> <i class="fa fa-envelope-o"></i> Unread Mail</a></li>
                                <li><a href="{{ action('MailController@getImportantMail')}}"> <i class="fa fa-certificate"></i> Important</a></li>
                                <li><a href="{{ action('MailController@getTrashMail')}}"> <i class="fa fa-trash-o"></i> Trash</a></li>
                            </ul>

                            <h5 class="tag-title">Characters</h5>
                            <ul class="tag-list" style="padding: 0">
                                @foreach($characters as $character)
                                    <li><a href="{{ action('MailController@MailForCharacter', ['characterID' => $character->characterID])}}"><img alt="image" height="24px" class="img-circle" src="https://imageserver.eveonline.com/Character/{{$character->characterID}}_32.jpg" /> {{$character->characterName}}</a></li>
                                @endforeach

                            </ul>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 animated fadeInRight">

                    <div class="mail-box-header">
                        <div class="mail-tools tooltip-demo pull-right">
                            <a id="allread" data-toggle="modal" data-target="#MarkAllAsReadModal" class="btn btn-white btn-sm" title="Mark ALL mails as read"><i class="fa fa-eye"></i> Mark all read</a>
                            {{--<button class="btn btn-white btn-sm" data-toggle="modal" data-target="#MarkAllAsReadModal"><i class="fa fa-eye"></i> Mark all read</button>--}}
                            {{--<button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="left" title="Mark all as read"><i class="fa fa-eye"></i> Mark all read</button>--}}
                            <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Mark as read" onclick="MarkAsRead();"><i class="fa fa-eye"></i> </button>
                            <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Mark as important" onclick="MarkAsImportant();"><i class="fa fa-exclamation"></i> </button>
                            <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to trash" onclick="MoveToTrash();"><i class="fa fa-trash-o"></i> </button>

                        </div>
                        <h2>
                            Inbox @if($unreadcount>0)({{$unreadcount}})@endif
                        </h2>


                    </div>
                    <div class="mail-box">



                        <div class="table-responsive">

                    <table class="table table-hover table-mail dataTables-mail">
                        <thead>
                        <tr>
                            <th></th>
                            <th>From</th>
                            <th>Subject</th>
                            <th>Sent</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($mail as $messagerecipient)
                            <tr @if($messagerecipient->read==false) class="unread" @else class="read" @endif>
                                <td class="check-mail">
                                    <input type="checkbox" class="i-checks" id="{{$messagerecipient->messageID}}" name="{{$messagerecipient->messageID}}">
                                </td>
                                <td class="mail-ontact"><a href="{{ action('CharacterController@show', ['id' => $messagerecipient->message->senderID])}}"><img alt="image" class="img-circle" height="24" src="https://imageserver.eveonline.com/Character/{{$messagerecipient->message->senderID}}_32.jpg" /> {{$messagerecipient->message->senderName}}</a>
                                    @if($messagerecipient->important)<span class="label label-danger pull-right">Important</span>@endif
                                </td>
                                <td class="mail-subject"><a href="{{ action('MailController@show', ['id' => $messagerecipient->messageID])}}">{{$messagerecipient->message->title}}</a></td>
                                <td class="text-right mail-date">{{$messagerecipient->message->sentDate->toDayDateTimeString()}}</td>
                                <td><a class="btn btn-primary btn-outline btn-sm" href="{{ action('MailController@show', ['id' => $messagerecipient->messageID])}}">View</a></td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                        </div>


                </div>

            </div>
        </div>
    </div>

    <div class="modal inmodal" id="MarkAllAsReadModal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-envelope-o modal-icon"></i>
                    <h4 class="modal-title">Mark ALL Mail As Read</h4>
                    <small class="font-bold">Set all your mail as read</small>
                </div>

                <div class="modal-body">
                    <p>Are you sure you want to mark all mail as read?</p>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="MarkAllAsRead();">Confirm</button>
                </div>

            </div>
        </div>
    </div>


@endsection

@section('scripts')

    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $('.dataTables-mail').dataTable({
                responsive: true,
                "pageLength": 25,
                "dom": 'T<"clear">lfrtip',
                "tableTools": {
                    "sSwfPath": "{{ URL::asset('js/plugins/dataTables/swf/copy_csv_xls_pdf.swf') }}"
                }
            });
        });

        function createListOfCheckedCheckBoxes()
        {
            //select the check boxes of class i-checks that are checked.  The message id is the name
            var selectedmails = [];

            $("input:checkbox").each(function() {
                if( ($(this).prop('checked')) && ($(this).attr('class')=='i-checks'))
                {
                    selectedmails.push($(this).attr("name") );
                }
             });

            return selectedmails.toString();
        }

        function SubmitAjax(route)
        {
            var selectedmails = createListOfCheckedCheckBoxes();

            if (selectedmails != '')
            {

               //create the form and submit it
                var form = document.createElement("form");
                form.setAttribute("method", "get");
                form.setAttribute("action", route);


                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", "_token");
                hiddenField.setAttribute("value", "{{ csrf_token() }}");
                form.appendChild(hiddenField);

                hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", "selectedmails");
                hiddenField.setAttribute("value", selectedmails);
                form.appendChild(hiddenField);

                document.body.appendChild(form);
                form.submit();

                return true
            }
            else
            {
                return false;
            }
        }

        function SetToastrOptions()
        {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "progressBar": true,
                "positionClass": "toast-top-full-width",
                "onclick": null,
                "showDuration": "400",
                "hideDuration": "1000",
                "timeOut": "6000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut" };
        }

        function MarkAsRead()
        {
            var route = "{{ action('MailController@MarkMailAsRead')}}";

            if (SubmitAjax(route) == false)
            {
                SetToastrOptions();
                toastr.warning( "No mails were selected to mark as read.  Please check the mails you wish to alter", "Mark As Read Failed" );
            }
        }

        function MarkAsImportant()
        {
            var route = "{{ action('MailController@MarkMailAsImportant')}}";

            if (SubmitAjax(route) == false)
            {
                SetToastrOptions();
                toastr.warning( "No mails were selected to mark as important.  Please check the mails you wish to alter", "Mark As Important Failed" );
            }
        }

        function MoveToTrash()
        {
            var route = "{{ action('MailController@MoveMailToTrash')}}";

            if (SubmitAjax(route) == false)
            {
                SetToastrOptions();
                toastr.warning( "No mails were selected to move.  Please check the mails you wish to alter", "Move to Trash Failed" );
            }
        }

        function MarkAllAsRead()
        {

               //alert('Checked:' + selectedmails);

                var route = "{{ action('MailController@MarkAllMailAsRead')}}";

                //create the form and submit it
                var form = document.createElement("form");
                form.setAttribute("method", "get");
                form.setAttribute("action", route);

                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", "_token");
                hiddenField.setAttribute("value", "{{ csrf_token() }}");
                form.appendChild(hiddenField);

                document.body.appendChild(form);
                form.submit();


        }

    </script>

@endsection