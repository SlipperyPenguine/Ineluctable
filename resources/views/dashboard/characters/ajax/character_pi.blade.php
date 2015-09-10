{{-- character pi --}}
  <div class="col-md-12">
    <div class="ibox">
      <div class="ibox-heading">
        <h3 class="ibox-title">Planetary Interaction</h3>
      </div><!-- /.box-header -->
      <div class="ibox-content no-padding">

        @foreach($colonies as $colony)

          <div class="ibox box-solid box-primary">
            <div class="ibox-heading">
              <h3 class="ibox-title">{{ $colony['planetName'] }} {{ $colony['planetTypeName'] }}</h3>
              <span class="pull-right">
                Upgrade Level: {{ $colony['upgradeLevel']}} Installations: {{ $colony['numberOfPins']}}
              </span>
            </div>
            <div class="ibox-content no-padding">
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-hover table-condensed compact" id="datatable">
                    <tbody>
                      <tr>
                        <th colspan="100%" style="text-align:center; font-size:120%">
                          Routes
                        </th>
                      </tr>
                      <tr>
                        <th>Installation Name</th>
                        <th>Product</th>
                        <th>Cycle Time</th>
                        <th>Quantity Per Cycle</th>
                        <th>Cycle End Time</th>
                        <th>Destination</th>
                      </tr>
                    </tbody>

                    @foreach($routes as $route)

                      @if($route->planetID == $colony['planetID'])
                        <tbody>
                          <tr>
                            <td>
                              {!!  ineluctable\Services\Helpers\Img::type($route->sourceTypeID, 16) !!}
                              {{ $route->sourceTypeName }}
                            </td>
                            <td>
                              {!!  ineluctable\Services\Helpers\Img::type($route->contentTypeID, 16) !!}
                              {{ $route->contentTypeName }} ({{ $route->quantity }})
                            </td>
                            <td>@if($route->cycleTime != 0){{ $route->cycleTime }} minutes @endif</td>
                            <td>@if($route->quantityPerCycle != 0){{ $route->quantityPerCycle }} @endif</td>
                            <td>@if( date('Y-m-d H:i:s') < ($route->expiryTime)){{ Carbon\Carbon::parse($route->expiryTime)->diffForHumans() }}@else No Active Cycle @endif</td>
                            <td>
                              {!! ineluctable\Services\Helpers\Img::type($route->destinationTypeID, 16) !!}
                              {{ $route->destinationTypeName }}
                            </td>
                          </tr>
                        </tbody>
                      @endif

                    @endforeach

                  </table>
                  <div class="ibox-footer"></div>
                </div><!-- /.col-md-12 -->

                <div class="col-md-6">
                  <table class="table table-hover table-condensed compact" id="datatable">
                    <tbody>
                      <tr>
                        <th colspan="100%" style="text-align:center; font-size:120%">
                          Links
                        </th>
                      </tr>
                      <tr>
                        <th>Source Installation</th>
                        <th>Level</th>
                        <th>Destination Installation</th>
                      </tr>
                    </tbody>

                    @foreach($links as $link)

                      @if($link->planetID == $colony['planetID'])
                        <tbody>
                          <tr>
                            <td>
                              {!! ineluctable\Services\Helpers\Img::type($link->sourceTypeID, 16) !!}
                              {{ $link->sourceTypeName }}
                            </td>
                            <td>{{ $link->linkLevel }}</td>
                            <td>
                              {!! ineluctable\Services\Helpers\Img::type($link->destinationTypeID, 16) !!}
                              {{ $link->destinationTypeName }}
                            </td>
                          </tr>
                        </tbody>
                      @endif

                    @endforeach

                  </table>
                </div> <!-- /.col-md-6 -->

                <div class="col-md-6">
                  <table class="table table-hover table-condensed compact" id="datatable">
                    <tbody>
                      <tr>
                        <th colspan="100%" style="text-align:center; font-size:120%">
                          Other Installations
                        </th>
                      </tr>
                      <tr>
                        <th>Installation Name</th>
                      </tr>
                    </tbody>

                    @foreach($installations as $installation)

                      @if($installation->planetID == $colony['planetID'])
                        <tbody>
                          <tr>
                            <td>
                              {!! ineluctable\Services\Helpers\Img::type($installation->typeID, 16) !!}
                              {{ $installation->typeName }}
                            </td>
                          </tr>
                        </tbody>
                      @endif

                    @endforeach

                  </table>
                </div> <!-- /.col-md-6 -->

              </div> <!-- /.row -->
            </div><!-- /.box-body -->
          </div> <!-- ./box -->

        @endforeach

      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div> <!-- ./col-md-12 -->
