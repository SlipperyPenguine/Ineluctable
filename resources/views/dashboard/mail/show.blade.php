@extends('dashboard.layouts.mainwithheading')

@section('heading')Mail Messages @endsection
@section('breadcrumbs')
    <li>
        <a href="{{ URL::asset('/home') }}">Home</a>
    </li>
    <li>
        <a href="{{ URL::asset('dashboard/home') }}">Dashboard</a>
    </li>
    <li>
        <a href="{{ URL::asset('dashboard/mail') }}">Mail Messages</a>
    </li>
    <li class="active">
        <strong>View Mail Message</strong>
    </li>
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-9">
            <div class="mail-box-header">
                <div class="pull-right tooltip-demo">
                   <a href="mailbox.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Mark as Read"><i class="fa fa-eye"></i> </a>
                    <a href="mailbox.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Mark as Important"><i class="fa fa-exclamation"></i> </a>
                    <a href="mailbox.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </a>
                </div>
                <h2>
                    <span class="font-noraml">Subject: </span>{{$message->title}}
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">

                    <h5>
                        <span class="pull-right font-noraml">{{$message->sentDate}}</span>
                        <span class="font-noraml">From: </span>{{$message->senderName}}
                    </h5>
                </div>
            </div>
            <div class="mail-box">


                <div class="mail-body">
                    <p>
                        {!!   $message->body->body !!}
                    </p>

                </div>

                <div class="mail-body text-right tooltip-demo">
                    <button title="" data-placement="top" data-toggle="tooltip" data-original-title="Toggle Read / Unread" class="btn btn-sm btn-white"><i class="fa fa-eye"></i> Mark Read</button>
                    <button title="" data-placement="top" data-toggle="tooltip" data-original-title="Toggle Important / normal" class="btn btn-sm btn-white"><i class="fa fa-exclamation"></i> Important</button>
                    <button title="" data-placement="top" data-toggle="tooltip" data-original-title="Toggle Trash / Inbox" class="btn btn-sm btn-white"><i class="fa fa-trash-o"></i> Remove</button>
                </div>
                <div class="clearfix"></div>


            </div>
        </div>

        <div class="col-lg-3">
            <div class="ibox">
                <div class="ibox-title">

                <h4>
                    Recipients:
                </h4>
                </div>
                <div class="ibox-content" id="recipients">
                    <i class='fa fa-cog fa-spin'></i> Loading...
                </div>
            </div>



            </div>

    </div>

@endsection

@section('scripts')

    <script>

        $( document ).ready(function() {
            $('div#recipients').load("{!! URL::route('mail.getAjaxRecipients',array(  'toCharacterIDs' => $message->toCharacterIDs,
                                                                                    'toCorpOrAllianceID' => $message->toCorpOrAllianceID,
                                                                                    'toListID' => $message->toListID
                                                                                            ))    !!}");
        });

    </script>


@endsection