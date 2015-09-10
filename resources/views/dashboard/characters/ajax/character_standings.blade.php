 {{-- character standings --}}
  <div class="col-md-12">
    <div class="ibox">
      <div class="ibox-heading">
        <h3 class="ibox-title">Standings</h3>
      </div><!-- /.box-header -->
      <div class="ibox-content no-padding">

        <div class="row">
          <div class="col-md-4">
            <table class="table table-hover table-condensed compact" id="datatable">
              <thead>
                <tr>
                  <td>Agent Name</td>
                  <td>Standing</td>
                </tr>
              </thead>
              <tbody>

                @foreach($agent_standings as $standing)

                  <tr>
                    <td>
                      {!!  ineluctable\Services\Helpers\Img::html($standing->fromID, 16) !!}
                      {{ $standing->fromName }}
                    </td>
                    <td @if($standing->standing>=0) class="text-green" @else class="text-red" @endif>{{ $standing->standing }}</td>
                  </tr>

                @endforeach

              </tbody>
            </table>
          </div>
          <div class="col-md-4">
            <table class="table table-hover table-condensed compact" id="datatable">
              <thead>
                <tr>
                  <td>NPC Corporation Name</td>
                  <td>Standing</td>
                </tr>
              </thead>
              <tbody>

                @foreach($npc_standings as $standing)

                  <tr>
                    <td>
                      {!!   ineluctable\Services\Helpers\Img::html($standing->fromID, 16) !!}
                      {{ $standing->fromName }}
                    </td>
                    <td @if($standing->standing>=0) class="text-green" @else class="text-red" @endif>{{ $standing->standing }}</td>
                  </tr>

                @endforeach

              </tbody>
            </table>
          </div>
          <div class="col-md-4">
            <table class="table table-hover table-condensed compact" id="datatable">
              <thead>
                <tr>
                  <td>Faction Name</td>
                  <td>Standing</td>
                </tr>
              </thead>
              <tbody>

                @foreach($faction_standings as $standing)

                  <tr>
                    <td>
                      {!!   ineluctable\Services\Helpers\Img::html($standing->fromID, 16) !!}
                      {{ $standing->fromName }}
                    </td>
                    <td @if($standing->standing>=0) class="text-green" @else class="text-red" @endif>{{ $standing->standing }}</td>
                  </tr>

                @endforeach

              </tbody>
            </table>
          </div>
        </div>

      </div><!-- /.box-body -->
    </div>
  </div> <!-- ./col-md-12 -->
