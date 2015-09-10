{{--Initial variable assignments--}}
@if ($decimal_seperator = ineluctable\Services\Settings\SettingHelper::getSetting('decimal_seperator')) @endif
@if ($thousand_seperator = ineluctable\Services\Settings\SettingHelper::getSetting('thousand_seperator')) @endif

{{-- character notification --}}
  <div class="col-md-12">
    <div class="ibox">
      <div class="ibox-heading">
        <h3 class="ibox-title">Research ({{ count($research) }})</h3>
      </div><!-- /.box-header -->
      <div class="ibox-content no-padding">
        <table class="table table-hover table-condensed compact" id="datatable">
          <thead>
            <tr>
              <th>Agent</td>
                <th>Skill</th>
                <th>Start Date</th>
                <th>Points Per Day</th>
                <th>Remainder Points</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($research as $agent)

                <tr>
                  <td>
                    {!!   ineluctable\Services\Helpers\Img::character($agent->agentID, 16) !!}
                    {{ $agent->itemName }}
                  </td>
                  <td>{{ $agent->typeName }}</td>
                  <td>{{ $agent->researchStartDate }}</td>
                  <td>{{ $agent->pointsPerDay }}</td>
                  <td>{{ number_format($agent->remainderPoints, 2, $decimal_seperator, $thousand_seperator) }}</td>
                </tr>

              @endforeach

            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div>
    </div> <!-- ./col-md-12 -->
