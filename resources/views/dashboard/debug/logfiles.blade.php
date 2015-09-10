@extends('dashboard.layouts.mainwithheading')

@section('heading')Log Files @endsection
@section('breadcrumbs')
  <li>
    <a href="{{ URL::asset('/home') }}">Home</a>
  </li>
  <li>
    <a href="{{ URL::asset('dashboard/home') }}">Dashboard</a>
  </li>
  <li>
    <a>Debug</a>
  </li>
  <li class="active">
    <strong>Log Files</strong>
  </li>
@endsection

@section('header')

  {{--Uses forms so include it--}}
  <link rel="stylesheet"  href="{{ URL::asset('css/inspinacss.css') }}">

@endsection

@section('content')



  <div class="ibox-content">
    <div class="panel-body">
      <div class="panel-group" id="accordion">
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="pull-right"><button id="btndeletelaravellog" class="btn btn-xs btn-danger">Delete</button></span>
            <h5 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Laravel Log File</a>
            </h5>
          </div>
          <div id="collapseTwo" class="panel-collapse collapse in">
            <div class="panel-body">
              <textarea style=" overflow: scroll;white-space: nowrap; word-wrap: normal" class="form-control" rows="30" id="laravellog">{{$laravellog}}</textarea>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="pull-right"><button id="btndeletephealerrorlog" class="btn btn-xs btn-danger">Delete</button></span>
            <h5 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Pheal Error Log File</a>
            </h5>
          </div>
          <div id="collapseOne" class="panel-collapse collapse in">
            <div class="panel-body">
              <textarea style=" overflow: scroll;white-space: nowrap; word-wrap: normal" class="form-control" rows="30" id="phealerrorlog">{{$phealerrorlog}}</textarea>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="pull-right"><button id="btndeletephealaccesslog" class="btn btn-xs btn-danger">Delete</button></span>
            <h5 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Pheal Access Log File</a>
            </h5>

          </div>
          <div id="collapseThree" class="panel-collapse collapse in">
            <div class="panel-body">
              <textarea style=" overflow: scroll;white-space: nowrap; word-wrap: normal" class="form-control" rows="30" id="phealaccesslog">{{$phealaccesslog}}</textarea>
            </div>
          </div>
        </div>


      </div>
    </div>


  </div>


@endsection

@section('scripts')


  <script>

    $("#btndeletelaravellog").click( function()
            {
              $("#laravellog").val("DELETED");

              request = $.ajax({
                url: "{{ action('DebugController@deletelaravellog') }}",
                type: "post",
                data: { _token: "{{ csrf_token() }}" }
              });
            }
    );

    $("#btndeletephealerrorlog").click( function()
            {
              $("#phealerrorlog").val("DELETED");

              request = $.ajax({
                url: "{{ action('DebugController@deletephealerrorlog') }}",
                type: "post",
                data: { _token: "{{ csrf_token() }}" }
              });
            }
    );

    $("#btndeletephealaccesslog").click( function()
            {
              $("#phealaccesslog").val("DELETED");

              request = $.ajax({
                url: "{{ action('DebugController@deletephealaccesslog') }}",
                type: "post",
                data: { _token: "{{ csrf_token() }}" }
              });
            }
    );
  </script>

@endsection


