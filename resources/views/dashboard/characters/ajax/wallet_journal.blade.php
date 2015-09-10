{{-- wallet journal --}}


  <div class="col-md-12">

    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>Account Balance ISK) </h5>
        <div class="ibox-tools"></div>
      </div>
      <div class="ibox-content">
        <div class="flot-chart">
          <div class="flot-chart-content" id="flot-line-chart"></div>
        </div>
      </div>
    </div>

    <div class="ibox">
      <div class="ibox-title">
        <h3 class="box-title">Wallet Journal ({{ count($wallet_journal) }})</h3>

          {{--<a href="{{ action('CharacterController@getFullWalletJournal', array('characterID' => $characterID)) }}" class="btn btn-default btn-sm pull-right">
            <i class="fa fa-money"></i> View Full Journal
          </a>--}}
        <div ibox-tools></div>
      </div><!-- /.box-header -->
      <div class="ibox-content no-padding">
        {{--<table class="table table-condensed compact table-hover" id="datatable">--}}
          <table class="table table-condensed compact table-hover dataTables-WalletJournal">
            <thead>
            <tr>
              <th>Date</th>
              <th>Type</th>
              <th>From</th>
              <th>To</th>
              <th>Location</th>
              <th>Amount</th>
              <th>Balance</th>
            </tr>
          </thead>
          <tbody>

            @foreach ($wallet_journal as $e)

              <tr @if ($e->amount < 0)class="danger" @endif>
                <td>
                  {{--<span data-toggle="tooltip" title="" data-original-title="{{ $e->date }}">
                    {{ Carbon\Carbon::parse($e->date)->diffForHumans() }}
                  </span>--}}
                  {{ $e->date->format('Y-m-d H:i') }}
                </td>
                <td>{{ $e->RefType->refTypeName }}</td>
                <td>
                  <img height="24px" alt="image" class="img-circle" src="https://imageserver.eveonline.com/Character/{{$e->ownerID1}}_32.jpg" />
                  {{ $e->ownerName1 }}
                </td>
                <td>
                  <img height="24px" alt="image" class="img-circle" src="https://imageserver.eveonline.com/Character/{{$e->ownerID2}}_32.jpg" />
                  {{ $e->ownerName2 }}
                </td>
                <td>{{ $e->argName1 }}</td>
                <td data-sort="{{ $e->amount }}">
                  {{ number_format($e->amount, 2, ineluctable\Services\Settings\SettingHelper::getSetting('decimal_seperator'),ineluctable\Services\Settings\SettingHelper::getSetting('thousand_seperator')) }}
                </td>
                <td data-sort="{{ $e->balance }}">
                  {{ number_format($e->balance, 2, ineluctable\Services\Settings\SettingHelper::getSetting('decimal_seperator'),ineluctable\Services\Settings\SettingHelper::getSetting('thousand_seperator')) }}
                </td>
              </tr>

            @endforeach

          </tbody>
        </table>
      </div><!-- /.box-body -->
    </div>

    <script>
      $(document).ready(function() {

        /*$('[data-toggle="tooltip"]').tooltip();*/

        $('.dataTables-WalletJournal').dataTable({
          responsive: true,
          "pageLength": 25,
          "order": [0, 'desc'],
          "dom": 'T<"clear">lfrtip',
          "tableTools": {
            "sSwfPath": "{{ URL::asset('js/plugins/dataTables/swf/copy_csv_xls_pdf.swf') }}"
          }
        });

      });


      $(function () {

        var flotdata = {{ $flotdata }};

        function numberWithCommas(x) {
          return x.toString().replace(/\B(?=(?:\d{3})+(?!\d))/g, ",");
        }

        function euroFormatter(v, axis) {
          return v.toFixed(axis.tickDecimals) + "€";
        }

        function doPlot(position) {
          $.plot($("#flot-line-chart"), [{
            data: flotdata,
            label: "Account Balance (ISK)"
          }], {
            xaxes: [{
              mode: 'time'
            }],
            yaxes: [{
              min: {{ $minyvalue }},
              tickFormatter: numberWithCommas
            }, {
              // align if we are to the right
              alignTicksWithAxis: position == "right" ? 1 : null,
              position: position
            }],
            series: {
              lines: { show: true, fill: false },
              points: { show: true }
            },
            legend: {
              position: 'sw'
            },
            colors: ["#1ab394"],
            grid: {
              color: "#999999",
              hoverable: true,
              clickable: true,
              tickColor: "#D4D4D4",
              borderWidth:0,
              hoverable: true //IMPORTANT! this is needed for tooltip to work,

            },
            tooltip: true,
            tooltipOpts: {
              content: "%s for %x was %y",
              xDateFormat: "%d-%m-%Y %H:%M:%S",

              onHover: function(flotItem, $tooltipEl) {
                // console.log(flotItem, $tooltipEl);
              }
            }

          });
        }

        doPlot("right");

      });

    </script>


