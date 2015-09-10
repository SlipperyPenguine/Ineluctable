@extends('app')

@section('content')

    <div class="container content no-bottom-space">
        <!-- Top Categories -->
        <div class="headline"><h2>Entosis Calculator</h2></div>

    </div>

    <{{--div class="col-md-12 col-xs-12">--}}
    <div class="container content no-padding">
        <div class="widget stacked">

                <!-- Content -->
                <div class="row" style="font-size:140%;">

                    <div class="col-md-4 text-center">
                        <label>Strategic Index</label><br>
                        <button id="option-index-strategic-0" class="btn btn-default btn-sm rounded" onclick="indexStrategic = 0; readjust();"><b>0</b></button>
                        <button id="option-index-strategic-1" class="btn btn-default btn-sm rounded" onclick="indexStrategic = 1; readjust();"><b>1</b></button>
                        <button id="option-index-strategic-2" class="btn btn-default btn-sm rounded" onclick="indexStrategic = 2; readjust();"><b>2</b></button>
                        <button id="option-index-strategic-3" class="btn btn-default btn-sm rounded" onclick="indexStrategic = 3; readjust();"><b>3</b></button>
                        <button id="option-index-strategic-4" class="btn btn-default btn-sm rounded" onclick="indexStrategic = 4; readjust();"><b>4</b></button>
                        <button id="option-index-strategic-5" class="btn btn-default btn-sm rounded" onclick="indexStrategic = 5; readjust();"><b>5</b></button>
                    </div>

                    <div class="col-md-4 text-center">
                        <label>Military Index</label><br>
                        <button id="option-index-military-0" class="btn btn-default btn-sm rounded" onclick="indexMilitary = 0; readjust();"><b>0</b></button>
                        <button id="option-index-military-1" class="btn btn-default btn-sm rounded" onclick="indexMilitary = 1; readjust();"><b>1</b></button>
                        <button id="option-index-military-2" class="btn btn-default btn-sm rounded" onclick="indexMilitary = 2; readjust();"><b>2</b></button>
                        <button id="option-index-military-3" class="btn btn-default btn-sm rounded" onclick="indexMilitary = 3; readjust();"><b>3</b></button>
                        <button id="option-index-military-4" class="btn btn-default btn-sm rounded" onclick="indexMilitary = 4; readjust();"><b>4</b></button>
                        <button id="option-index-military-5" class="btn btn-default btn-sm rounded" onclick="indexMilitary = 5; readjust();"><b>5</b></button>
                    </div>

                    <div class="col-md-4 text-center">
                        <label>Industrial Index</label><br>
                        <button id="option-index-industrial-0" class="btn btn-default btn-sm rounded" onclick="indexIndustrial = 0; readjust();"><b>0</b></button>
                        <button id="option-index-industrial-1" class="btn btn-default btn-sm rounded" onclick="indexIndustrial = 1; readjust();"><b>1</b></button>
                        <button id="option-index-industrial-2" class="btn btn-default btn-sm rounded" onclick="indexIndustrial = 2; readjust();"><b>2</b></button>
                        <button id="option-index-industrial-3" class="btn btn-default btn-sm rounded" onclick="indexIndustrial = 3; readjust();"><b>3</b></button>
                        <button id="option-index-industrial-4" class="btn btn-default btn-sm rounded" onclick="indexIndustrial = 4; readjust();"><b>4</b></button>
                        <button id="option-index-industrial-5" class="btn btn-default btn-sm rounded" onclick="indexIndustrial = 5; readjust();"><b>5</b></button>
                    </div>

                </div>
                <br>
                <br>
                <hr>
                <br>
                <br>

                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Station Service</b></h3>
                            </div>
                            <div class="panel-body text-center">
                                <h1><span id="time-station">?</span></h1>
                            </div>
                            <div class="panel-footer">
                                <h4 class="panel-title">Designated Capital System<span class="pull-right">N/A</span></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Structure / Command Node</b></h3>
                            </div>
                            <div class="panel-body text-center">
                                <h1><span id="time-structure-1">?</span></h1>
                            </div>
                            <div class="panel-footer">
                                <h4 class="panel-title">Designated Capital System<span class="pull-right" id="time-structure-2">?</span></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Vulnerability Window</b></h3>
                            </div>
                            <div class="panel-body text-center">
                                <h1><span id="time-vuln-1">?</span></h1>
                            </div>
                            <div class="panel-footer">
                                <h4 class="panel-title">Designated Capital System<span class="pull-right" id="time-vuln-2">?</span></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Warmup / Cycle</b> <span class="pull-right" style="font-size:90%;">Subcapital</span></h3>
                            </div>
                            <div class="panel-body text-center">
                                <h2><span class="text-muted">T1 </span> <span id="time-subcap-warmup-1">?</span><br><span class="text-muted">T2 </span> <span id="time-subcap-warmup-2">?</span></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Warmup / Cycle</b> <span class="pull-right" style="font-size:90%;">Capital</span></h3>
                            </div>
                            <div class="panel-body text-center">
                                <h2><span class="text-muted">T1 </span> <span id="time-capital-warmup-1">?</span><br><span class="text-muted">T2 </span> <span id="time-capital-warmup-2">?</span></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <script src="assets/js/entosis.js"></script>

            </div>
        <!-- END widget-content -->

        </div>
        <!-- Content -->


@stop