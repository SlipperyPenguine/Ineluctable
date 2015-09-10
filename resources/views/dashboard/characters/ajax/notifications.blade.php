{{-- character notification --}}

  <div class="col-md-12">
    <div class="ibox">
      <div class="ibox-header">
        <h3 class="ibox-title">Notifications ({{ count($notifications) }})</h3>
      </div><!-- /.box-header -->
      <div class="ibox-content no-padding">
        <table class="table table-hover table-condensed compact" id="datatable">
          <thead>
            <tr>
              <th style="width: 10px">#</th>
              <th>Date</th>
              <th>From</th>
              <th>Notification Type</th>
              <th>Sample</th>
              <th></th>
            </tr>
          </thead>
          <tbody>

            @foreach ($notifications as $note)

              <tr>
                <td>{{ $note->notificationID }}</td>
                <td data-order="{{ $note->sentDate }}">
                  <span data-toggle="tooltip" title="" data-original-title="{{ $note->sentDate }}">
                    {{ Carbon\Carbon::parse($note->sentDate)->diffForHumans() }}
                  </span>
                </td>
                <td>{{ $note->senderName }}</td>
                <td><b>{{ $note->type->description }}</b></td>
                <td><b>{{ str_limit($note->body->text, 80, $end = '...') }}</b></td>
                <td></td>
              </tr>

            @endforeach

          </tbody>
        </table>
      </div><!-- /.box-body -->
    </div>
  </div> <!-- ./col-md-12 -->

