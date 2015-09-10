{{-- character contacts --}}

  <div class="col-md-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Contact List ({{ count($contact_list) }})</h3>
      </div><!-- /.box-header -->
      <div class="box-body no-padding">
        <div class="row">

          @foreach ($contact_list->chunk(6) as $list)

            <div class="col-md-2">
              <table class="table table-hover table-condensed">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Standing</th>
                  </tr>
                </thead>
                <tbody>

                  @foreach ($list as $contact)

                    <tr>
                      <td>
                        <a href="{{ action('CharacterController@show', array('characterID' => $contact->contactID)) }}">
                          {!!   ineluctable\Services\Helpers\Img::character($contact->contactID, 16) !!}
                          {{ $contact->contactName }}
                        </a>
                      </td>
                      <td>
                        @if ($contact->standing == 0)
                          {{ number_format($contact->standing, 2, ineluctable\Services\Settings\SettingHelper::getSetting('decimal_seperator'),ineluctable\Services\Settings\SettingHelper::getSetting('thousand_seperator')) }}
                        @elseif ($contact->standing > 0)
                          <span class="text-green">{{ number_format($contact->standing, 2, ineluctable\Services\Settings\SettingHelper::getSetting('decimal_seperator'),ineluctable\Services\Settings\SettingHelper::getSetting('thousand_seperator')) }}</span>
                        @else
                          <span class="text-red">{{ number_format($contact->standing, 2, ineluctable\Services\Settings\SettingHelper::getSetting('decimal_seperator'),ineluctable\Services\Settings\SettingHelper::getSetting('thousand_seperator')) }}</span>
                        @endif
                      </td>
                    </tr>

                  @endforeach

                </tbody>
              </table>
            </div> <!-- ./col-md-2 -->

          @endforeach

        </div><!-- ./row -->
      </div><!-- /.box-body -->
    </div>
  </div> <!-- ./col-md-12 -->

@if(count($corpcontacts)>0)
  <div class="col-md-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Corporation Contact List ({{ count($corpcontacts) }})</h3>
      </div><!-- /.box-header -->
      <div class="box-body no-padding">
        <div class="row">

          @foreach ($corpcontacts->chunk(6) as $list)

            <div class="col-md-2">
              <table class="table table-hover table-condensed">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Standing</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($list as $contact)

                  <tr>
                    <td>
                      <a href="{{ action('CharacterController@show', array('characterID' => $contact->contactID)) }}">
                        {!!   ineluctable\Services\Helpers\Img::character($contact->contactID, 16) !!}
                        {{ $contact->contactName }}
                      </a>
                    </td>
                    <td>
                      @if ($contact->standing == 0)
                        {{ number_format($contact->standing, 2, ineluctable\Services\Settings\SettingHelper::getSetting('decimal_seperator'),ineluctable\Services\Settings\SettingHelper::getSetting('thousand_seperator')) }}
                      @elseif ($contact->standing > 0)
                        <span class="text-green">{{ number_format($contact->standing, 2, ineluctable\Services\Settings\SettingHelper::getSetting('decimal_seperator'),ineluctable\Services\Settings\SettingHelper::getSetting('thousand_seperator')) }}</span>
                      @else
                        <span class="text-red">{{ number_format($contact->standing, 2, ineluctable\Services\Settings\SettingHelper::getSetting('decimal_seperator'),ineluctable\Services\Settings\SettingHelper::getSetting('thousand_seperator')) }}</span>
                      @endif
                    </td>
                  </tr>

                @endforeach

                </tbody>
              </table>
            </div> <!-- ./col-md-2 -->

          @endforeach

        </div><!-- ./row -->
      </div><!-- /.box-body -->
    </div>
  </div> <!-- ./col-md-12 -->
@endif

@if(count($alliancecontacts)>0)
  <div class="col-md-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Alliance Contact List ({{ count($alliancecontacts) }})</h3>
      </div><!-- /.box-header -->
      <div class="box-body no-padding">
        <div class="row">

          @foreach ($alliancecontacts->chunk(6) as $list)

            <div class="col-md-2">
              <table class="table table-hover table-condensed">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Standing</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($list as $contact)

                  <tr>
                    <td>
                      <a href="{{ action('CharacterController@show', array('characterID' => $contact->contactID)) }}">
                        {!!   ineluctable\Services\Helpers\Img::character($contact->contactID, 16) !!}
                        {{ $contact->contactName }}
                      </a>
                    </td>
                    <td>
                      @if ($contact->standing == 0)
                        {{ number_format($contact->standing, 2, ineluctable\Services\Settings\SettingHelper::getSetting('decimal_seperator'),ineluctable\Services\Settings\SettingHelper::getSetting('thousand_seperator')) }}
                      @elseif ($contact->standing > 0)
                        <span class="text-green">{{ number_format($contact->standing, 2, ineluctable\Services\Settings\SettingHelper::getSetting('decimal_seperator'),ineluctable\Services\Settings\SettingHelper::getSetting('thousand_seperator')) }}</span>
                      @else
                        <span class="text-red">{{ number_format($contact->standing, 2, ineluctable\Services\Settings\SettingHelper::getSetting('decimal_seperator'),ineluctable\Services\Settings\SettingHelper::getSetting('thousand_seperator')) }}</span>
                      @endif
                    </td>
                  </tr>

                @endforeach

                </tbody>
              </table>
            </div> <!-- ./col-md-2 -->

          @endforeach

        </div><!-- ./row -->
      </div><!-- /.box-body -->
    </div>
  </div> <!-- ./col-md-12 -->
@endif