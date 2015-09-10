@extends('dashboard.layouts.mainwithheading')

@section('heading')Jobs @endsection
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
        <strong>Jobs</strong>
    </li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-heading">
                <h3 class="ibox-title">Queued Jobs ({{ count($jobs) }})</h3>
            </div><!-- /.box-header -->
            <div class="ibox-content">
                <table class="table-striped table-hover table" style="table-layout:fixed ; word-wrap: break-word">
                    <thead>
                        <tr>
                            <th width="40px">ID</th>
                            <th width="100px">Queue</th>
                            <th width="150px">Created</th>
                            <th width="90px">Attempts</th>
                            <th>Payload</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobs as $job)
                            <tr>
                                <td>{{$job->id}}</td>
                                <td>{{$job->queue}}</td>
                                <td>{{$job->created_at}}</td>
                                <td>{{$job->attempts}}</td>
                                <td>{{$job->payload}}</td>
                             </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
<div class="row">

    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-heading">
                <h3 class="ibox-title">Completed Jobs</h3>
            </div><!-- /.box-header -->
            <div class="ibox-content">
                <table class="table-striped table-hover table" style="table-layout:fixed ; word-wrap: break-word">
                    <thead>
                    <tr>
                        <th width="40px">ID</th>
                        <th width="100px">Queue</th>
                        <th width="150px">Started</th>
                        <th width="90px">Duration</th>
                        <th>Command</th>
                        <th>Parameters</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($completedjobs as $job)
                        <tr>
                            <td>{{$job->jobid}}</td>
                            <td>{{$job->queue}}</td>
                            <td>{{$job->started}}</td>
                            <td>{{$job->duration}}</td>
                            <td>{{$job->command}}</td>
                            <td>{{$job->params}}</td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    @endsection