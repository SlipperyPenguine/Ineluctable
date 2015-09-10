{{-- character mail --}}

  <div class="col-md-12">
    <div class="ibox">
      <div class="ibox-title">
        <span class="pull-right"><a class="btn btn-primary" href="{{ action('MailController@MailForCharacter', ['characterID' => $characterID])}}">Read All Mail</a> </span>
        <h3 class="box-title">Mail ({{ count($mail) }})</h3>
        <div class="ibox-tools"></div>

      </div><!-- /.box-header -->
      <div class="ibox-content">
        <div class="table-responsive">

          <table class="table table-hover table-mail dataTables-mail">
            <thead>
            <tr>
              <th>From</th>
              <th>Subject</th>
              <th>Sent</th>
              <th></th>
            </tr>
            </thead>

            <tbody>

            @foreach($mail as $messagerecipient)
              <tr @if($messagerecipient->read==false) class="unread" @else class="read" @endif>

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
      </div><!-- /.box-body -->
    </div>
  </div> <!-- ./col-md-12 -->


<script>
  $(document).ready(function() {

    /*$('[data-toggle="tooltip"]').tooltip();*/

    $('.dataTables-Mail').dataTable({
      responsive: true,
      "pageLength": 25,
      "order": [0, 'desc'],
      "dom": 'T<"clear">lfrtip',
      "tableTools": {
        "sSwfPath": "{{ URL::asset('js/plugins/dataTables/swf/copy_csv_xls_pdf.swf') }}"
      }
    });

  });

</script>

