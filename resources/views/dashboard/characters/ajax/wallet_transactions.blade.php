{{-- wallet transactions --}}
  <div class="col-md-12">
    <div class="ibox">
      <div class="ibox-title">
        <h5>Wallet Transactions ({{ count($wallet_transactions) }})</h5>
        <div class="ibox-tools"></div>
      </div><!-- /.box-header -->
      <div class="ibox-content">
        <table class="table table-condensed compact table-hover dataTables-WalletTransactions">
          <thead>
            <tr>
              <th>Date</th>
              <th>Type</th>
              <th>#</th>
              <th>Per Item</th>
              <th>Total</th>
              <th>Client</th>
              <th>Type</th>
              <th>Station Name</th>
            </tr>
          </thead>
          <tbody>

            @foreach ($wallet_transactions as $e)

              <tr @if ($e->transactionType == 'buy')class="danger" @endif>
                <td data-order="{{ $e->transactionDateTime }}">
                  <span data-toggle="tooltip" title="" data-original-title="{{ $e->transactionDateTime }}">
                    {{ Carbon\Carbon::parse($e->transactionDateTime)->diffForHumans() }}
                  </span>
                </td>
                <td>
                  <img alt="image" height="24px" class="img-circle" src="https://imageserver.eveonline.com/Type/{{$e->typeID}}_32.png" />
                  {{ $e->typeName }}
                </td>
                <td>{{ $e->quantity }}</td>
                <td data-sort="{{ $e->price }}">
                  {{ number_format($e->price, 2, ineluctable\Services\Settings\SettingHelper::getSetting('decimal_seperator'),ineluctable\Services\Settings\SettingHelper::getSetting('thousand_seperator')) }} ISK
                </td>
                <td data-sort="{{ $e->price * $e->quantity }}">
                  {{ number_format($e->price * $e->quantity, 2,  ineluctable\Services\Settings\SettingHelper::getSetting('decimal_seperator'),ineluctable\Services\Settings\SettingHelper::getSetting('thousand_seperator')) }} ISK
                </td>
                <td>{{ $e->clientName }}</td>
                <td>{{ $e->transactionType }}</td>
                <td>{{ $e->stationName }}</td>
              </tr>

            @endforeach

          </tbody>
        </table>
      </div><!-- /.box-body -->
    </div>
  </div> <!-- ./col-md-12 -->




<script>
  $(document).ready(function() {

    /*$('[data-toggle="tooltip"]').tooltip();*/

    $('.dataTables-WalletTransactions').dataTable({
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

