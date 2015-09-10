{{-- character killmails --}}
  <div class="col-md-12">
    <div class="ibox">
      <div class="ibox-heading">
        <h3 class="ibox-title">Kill Mails ({{ count($killmails) }})</h3>
      </div><!-- /.box-header -->
      <div class="ibox-content no-padding">
        @if(count($killmails)>0)
        <div class="row">

          @foreach ($killmails->chunk(round(count($killmails)/2)) as $killmail_list)

            <div class="col-md-6">
              <table class="table table-hover table-condensed">
                <thead>
                  <tr>
                    <th>Victim</th>
                    <th>Ship (zKB Link)</th>
                    <th>Location</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>

                  @foreach ($killmail_list as $killmail)

                    <tr>
                      <td>
                        <a href="{{ action('CharacterController@show', array('characterID' => $killmail->characterID)) }}">
                          {!!  ineluctable\Services\Helpers\Img::character($killmail->characterID, 16)  !!}
                          {{ $killmail->characterName }}
                          {{-- if the characterID == victim characterID, then this is a loss --}}
                          @if($killmail->characterID == $characterID)
                          <span class="text-danger"><i>(loss!)</i></span>
                          @endif
                        </a>
                      </td>
                      <td>
                        <a href="https://zkillboard.com/kill/{{ $killmail->killID }}/" target="_blank">
                          {!! ineluctable\Services\Helpers\Img::type($killmail->shipTypeID, 16)  !!}
                          {{ $killmail->typeName }}
                        </a>
                      </td>
                      <td>
                        {{ $killmail->solarSystemName }}
                      </td>
                      <td>
                        <span class="text-muted" data-toggle="tooltip" title="" data-placement="top" data-original-title="API Key Details">
                          ({{ Carbon\Carbon::parse($killmail->killTime)->diffForHumans() }})
                        </span>
                      </td>
                    </tr>

                  @endforeach

                </tbody>
              </table>
            </div> <!-- ./col-md-2 -->

          @endforeach

        </div><!-- ./row -->
          @endif
      </div><!-- /.box-body -->
    </div>
  </div> <!-- ./col-md-12 -->