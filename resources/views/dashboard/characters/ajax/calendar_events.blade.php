{{-- character calendar events --}}
  <div class="col-md-12">
    <div class="ibox">
      <div class="ibox-heading">
        <h3 class="ibox-title">Calendar Events ({{ count($calendar_events) }})</h3>
      </div><!-- /.box-header -->
      <div class="ibox-content no-padding">
        <table class="table table-hover table-condensed compact" id="datatable">
          <thead>
            <tr>
              <th>Owner Name</th>
              <th>Event Date</th>
              <th>Event Title</th>
              <th>Duration</th>
              <th>Response</th>
              <th>Event Text</th>
            </tr>
          </thead>
          <tbody>

            @foreach ($calendar_events as $event)

              <tr>
                <td>{{ $event->ownerName }}</td>
                <td>{{$event->eventDate->diffForHumans()}} ({{ $event->eventDate->toDayDateTimeString() }})</td>
                <td>{{ $event->eventTitle }}</td>
                <td>{{ $event->duration }}</td>
                <td>{{ $event->response }}</td>
                <td>{!! $event->eventText !!}</td>
              </tr>

            @endforeach

          </tbody>
        </table>
      </div><!-- /.box-body -->
    </div>
  </div> <!-- ./col-md-12 -->
