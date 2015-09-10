@extends('dashboard.layouts.mainwithheading')

@section('heading')Browser Check @endsection
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
    <strong>Browser Check</strong>
  </li>
@endsection

@section('header')

  {{--Uses forms so include it--}}
  <link rel="stylesheet"  href="{{ URL::asset('css/inspinacss.css') }}">
  <meta http-equiv="refresh" content="10; URL=http://localhost/ineluctable/public/dashboard/debug/browser">

@endsection

@section('content')

  <div class="row">
    This page will refresh in <span id="countdown">30 Seconds</span>

  </div>

  <div class="row">
    <div class="col-md-8" >
      <div class="headline"><h2>Headers</h2></div>

      <div id="result">
        <ul>
           @foreach($headers as $key => $value)


                <li>{{ $key . ' => ' . $value }}</li>

            @endforeach
        </ul>

      </div>
    </div>

  </div>

@endsection

@section('scripts')

  <script>
    setTimeout(function(){
      window.location.reload(1);
    }, 30000);
  </script>

  <script>

    var count=30;

    var counter=setInterval(timer, 1000); //1000 will  run it every 1 second

    function timer()
    {
      count=count-1;
      if (count <= 0)
      {
        clearInterval(counter);
        //counter ended, do something here
        return;
      }

      document.getElementById("countdown").innerHTML=count + " seconds";
    }

  </script>

@endsection


