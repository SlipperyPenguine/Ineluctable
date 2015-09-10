@extends('app')

@section('header')

@stop

@section('content')



    <div class="container content no-bottom-space">

            <!-- Top Categories -->
            <div class="headline"><h2>Jump Fatigue Calculator</h2></div>

        <div id="option-travel">
	    <label class="col-md-2">I travel by </label>
	    <button id="option-travel-1" class="btn btn-default btn-sm rounded " onclick="selectTravel = 1; readjust();"><b>Jumpbridge</b></button>
	    <button id="option-travel-2" class="btn btn-default btn-sm rounded " onclick="selectTravel = 2; readjust();"><b>Cyno / Titan Bridge</b></button>
	    <button id="option-travel-3" class="btn btn-default btn-sm rounded " onclick="selectTravel = 3; readjust();"><b>Covert Cyno / Black Ops Bridge</b></button>
	</div>

        <br>

	<div id="option-ship-covert" class="hide">
	    <label class="col-md-2">I am in a </label>
	    <button id="option-ship-covert-1" class="btn btn-default btn-sm rounded" onclick="selectShipCovert = 1; readjust();"><b>Black Ops, Covert Ops, Force Recon</b></button>
	    <button id="option-ship-covert-2" class="btn btn-default btn-sm rounded" onclick="selectShipCovert = 2; readjust();"><b>Blockade Runner</b></button>
	</div>

	<div id="option-ship"  class="hide">
	    <label class="col-md-2">I am in a </label>
	    <button id="option-ship-1" class="btn btn-default btn-sm rounded" onclick="selectShip = 1; readjust();"><b>Black Ops</b></button>
	    <button id="option-ship-2" class="btn btn-default btn-sm rounded" onclick="selectShip = 2; readjust();"><b>Jumpfreighter</b></button>
	    <button id="option-ship-3" class="btn btn-default btn-sm rounded" onclick="selectShip = 3; readjust();"><b>Standard-, Advanced-, Capital-Industrial, Freighter</b></button>
	    <button id="option-ship-4" class="btn btn-default btn-sm rounded" onclick="selectShip = 4; readjust();"><b>Everything else</b></button>
	</div>

        <br>

	<div id="option-jdc"  class="hide">
	    <label class="col-md-2">I or the bridging pilot have </label>
	    <button id="option-jdc-1" class="btn btn-default btn-sm rounded" onclick="selectJdc = 1; readjust();"><b>JDC I</b></button>
	    <button id="option-jdc-2" class="btn btn-default btn-sm rounded" onclick="selectJdc = 2; readjust();"><b>JDC II</b></button>
	    <button id="option-jdc-3" class="btn btn-default btn-sm rounded" onclick="selectJdc = 3; readjust();"><b>JDC III</b></button>
	    <button id="option-jdc-4" class="btn btn-default btn-sm rounded" onclick="selectJdc = 4; readjust();"><b>JDC IV</b></button>
	    <button id="option-jdc-5" class="btn btn-default btn-sm rounded" onclick="selectJdc = 5; readjust();"><b>JDC V</b></button>
	</div>
        <br/>

{{--        <div class="headline-center-v2 headline-center-v2-dark">
            <span class="bordered-icon"><i class="fa fa-th-large"></i></span>
        </div><!--/Headline Center V2-->--}}
    </div><!--/container-->

    <div class="container content no-top-space">

	<span class="pull-left">
	    Fatigue Bonus: <b id="fatigue-bonus"></b>
	</span>
	<span class="pull-right">
	    Set all distances to
	    <button class="btn btn-default btn-xs btn-danger" onclick="resetMin();"><b>MIN</b></button>
	    <button class="btn btn-default btn-xs btn-danger" onclick="resetMax();"><b>MAX</b></button>
	</span>



                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Jump<br>&nbsp;</th>
                        <th class="text-right">Cooldown<br>&nbsp;</th>
                        <th class="text-center">Wait Period<br><span class="text-muted"><small>(optional)</small></span></th>
                        <th class="text-right">Fatigue*<br><span class="text-muted"><small>(before jump)</small></span></th>
                        <th class="text-center">Jump Distance<br>&nbsp;</th>
                        <th class="text-right">Fatigue*<br><span class="text-muted"><small>(after jump)</small></span></th>
                        <th class="text-right">Travel Time<br><span class="text-muted"><small>(sum)</small></span></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr id="row-1">
                        <td style="vertical-align:middle;"><span style="font-size:140%;">#1</span></td>
                        <td class="text-right" style="vertical-align:middle;"><b><span style="font-size:140%;" class="text-muted">N/A</span></b></td>
                        <td class="text-center" style="vertical-align:middle;"><b><span style="font-size:140%;" class="text-muted">N/A</span></b></td>
                        <td class="text-right col-md-2" style="vertical-align:middle;">
                            <form class="form-inline">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input id="prefatigue-input-h" type="number" class="form-control text-right" onchange="recalc();" onkeyup="recalc();" placeholder="HH" max="719" min="0" step="1" style="width: 50%;">
                                        <input id="prefatigue-input-m" type="number" class="form-control text-right" onchange="recalc();" onkeyup="recalc();" placeholder="MM" max="59"  min="0" step="1" style="width: 50%;">
                                    </div>
                                </div>
                            </form>
                        </td>
                        <td class="text-center">
                            <br>
                            <input id="distance-1-input" style="display: inline;" onchange="recalc();" onkeyup="recalc();" type="range" min="0" max="0" step="0.01">
                            <span id="distance-1-min" class="pull-left text-muted"></span>
                            <span id="distance-1-value"></span>
                            <span id="distance-1-max" class="pull-right text-muted"></span>
                        </td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-1-fatigue-after" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-1-time" style="font-size:140%;">&nbsp;</span></b></td>
                    </tr>
                    <tr id="row-2" class="hide">
                        <td style="vertical-align:middle;"><span style="font-size:140%;">#2</span></td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-2-cooldown" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-center">
                            <br>
                            <input id="wait-2-input" style="display: inline;" onchange="recalc();" onkeyup="recalc();" type="range" min="0" max="0" step="1">
                            <span id="wait-2-min" class="pull-left text-muted"></span>
                            <span id="wait-2-value"></span>
                            <span id="wait-2-max" class="pull-right text-muted"></span>
                        </td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-2-fatigue-before" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-center">
                            <br>
                            <input id="distance-2-input" style="display: inline;" onchange="recalc();" onkeyup="recalc();" type="range" min="0" max="0" step="0.01">
                            <span id="distance-2-min" class="pull-left text-muted"></span>
                            <span id="distance-2-value"></span>
                            <span id="distance-2-max" class="pull-right text-muted"></span>
                        </td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-2-fatigue-after" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-2-time" style="font-size:140%;">&nbsp;</span></b></td>
                    </tr>
                    <tr id="row-3" class="hide">
                        <td style="vertical-align:middle;"><span style="font-size:140%;">#3</span></td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-3-cooldown" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-center">
                            <br>
                            <input id="wait-3-input" style="display: inline;" onchange="recalc();" onkeyup="recalc();" type="range" min="0" max="0" step="1">
                            <span id="wait-3-min" class="pull-left text-muted"></span>
                            <span id="wait-3-value"></span>
                            <span id="wait-3-max" class="pull-right text-muted"></span>
                        </td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-3-fatigue-before" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-center">
                            <br>
                            <input id="distance-3-input" style="display: inline;" onchange="recalc();" onkeyup="recalc();" type="range" min="0" max="0" step="0.01">
                            <span id="distance-3-min" class="pull-left text-muted"></span>
                            <span id="distance-3-value"></span>
                            <span id="distance-3-max" class="pull-right text-muted"></span>
                        </td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-3-fatigue-after" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-3-time" style="font-size:140%;">&nbsp;</span></b></td>
                    </tr>
                    <tr id="row-4" class="hide">
                        <td style="vertical-align:middle;"><span style="font-size:140%;">#4</span></td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-4-cooldown" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-center">
                            <br>
                            <input id="wait-4-input" style="display: inline;" onchange="recalc();" onkeyup="recalc();" type="range" min="0" max="0" step="1">
                            <span id="wait-4-min" class="pull-left text-muted"></span>
                            <span id="wait-4-value"></span>
                            <span id="wait-4-max" class="pull-right text-muted"></span>
                        </td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-4-fatigue-before" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-center">
                            <br>
                            <input id="distance-4-input" style="display: inline;" onchange="recalc();" onkeyup="recalc();" type="range" min="0" max="0" step="0.01">
                            <span id="distance-4-min" class="pull-left text-muted"></span>
                            <span id="distance-4-value"></span>
                            <span id="distance-4-max" class="pull-right text-muted"></span>
                        </td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-4-fatigue-after" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-4-time" style="font-size:140%;">&nbsp;</span></b></td>
                    </tr>
                    <tr id="row-5" class="hide">
                        <td style="vertical-align:middle;"><span style="font-size:140%;">#5</span></td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-5-cooldown" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-center">
                            <br>
                            <input id="wait-5-input" style="display: inline;" onchange="recalc();" onkeyup="recalc();" type="range" min="0" max="0" step="1">
                            <span id="wait-5-min" class="pull-left text-muted"></span>
                            <span id="wait-5-value"></span>
                            <span id="wait-5-max" class="pull-right text-muted"></span>
                        </td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-5-fatigue-before" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-center">
                            <br>
                            <input id="distance-5-input" style="display: inline;" onchange="recalc();" onkeyup="recalc();" type="range" min="0" max="0" step="0.01">
                            <span id="distance-5-min" class="pull-left text-muted"></span>
                            <span id="distance-5-value"></span>
                            <span id="distance-5-max" class="pull-right text-muted"></span>
                        </td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-5-fatigue-after" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-5-time" style="font-size:140%;">&nbsp;</span></b></td>
                    </tr>
                    <tr id="row-6" class="hide">
                        <td style="vertical-align:middle;"><span style="font-size:140%;">#6</span></td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-6-cooldown" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-center">
                            <br>
                            <input id="wait-6-input" style="display: inline;" onchange="recalc();" onkeyup="recalc();" type="range" min="0" max="0" step="1">
                            <span id="wait-6-min" class="pull-left text-muted"></span>
                            <span id="wait-6-value"></span>
                            <span id="wait-6-max" class="pull-right text-muted"></span>
                        </td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-6-fatigue-before" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-center">
                            <br>
                            <input id="distance-6-input" style="display: inline;" onchange="recalc();" onkeyup="recalc();" type="range" min="0" max="0" step="0.01">
                            <span id="distance-6-min" class="pull-left text-muted"></span>
                            <span id="distance-6-value"></span>
                            <span id="distance-6-max" class="pull-right text-muted"></span>
                        </td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-6-fatigue-after" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-6-time" style="font-size:140%;">&nbsp;</span></b></td>
                    </tr>
                    <tr id="row-7" class="hide">
                        <td style="vertical-align:middle;"><span style="font-size:140%;">#7</span></td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-7-cooldown" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-center">
                            <br>
                            <input id="wait-7-input" style="display: inline;" onchange="recalc();" onkeyup="recalc();" type="range" min="0" max="0" step="1">
                            <span id="wait-7-min" class="pull-left text-muted"></span>
                            <span id="wait-7-value"></span>
                            <span id="wait-7-max" class="pull-right text-muted"></span>
                        </td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-7-fatigue-before" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-center">
                            <br>
                            <input id="distance-7-input" style="display: inline;" onchange="recalc();" onkeyup="recalc();" type="range" min="0" max="0" step="0.01">
                            <span id="distance-7-min" class="pull-left text-muted"></span>
                            <span id="distance-7-value"></span>
                            <span id="distance-7-max" class="pull-right text-muted"></span>
                        </td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-7-fatigue-after" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-7-time" style="font-size:140%;">&nbsp;</span></b></td>
                    </tr>
                    <tr id="row-8" class="hide">
                        <td style="vertical-align:middle;"><span style="font-size:140%;">#8</span></td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-8-cooldown" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-center">
                            <br>
                            <input id="wait-8-input" style="display: inline;" onchange="recalc();" onkeyup="recalc();" type="range" min="0" max="0" step="1">
                            <span id="wait-8-min" class="pull-left text-muted"></span>
                            <span id="wait-8-value"></span>
                            <span id="wait-8-max" class="pull-right text-muted"></span>
                        </td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-8-fatigue-before" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-center">
                            <br>
                            <input id="distance-8-input" style="display: inline;" onchange="recalc();" onkeyup="recalc();" type="range" min="0" max="0" step="0.01">
                            <span id="distance-8-min" class="pull-left text-muted"></span>
                            <span id="distance-8-value"></span>
                            <span id="distance-8-max" class="pull-right text-muted"></span>
                        </td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-8-fatigue-after" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-8-time" style="font-size:140%;">&nbsp;</span></b></td>
                    </tr>
                    <tr id="row-9" class="hide">
                        <td style="vertical-align:middle;"><span style="font-size:140%;">#9</span></td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-9-cooldown" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-center">
                            <br>
                            <input id="wait-9-input" style="display: inline;" onchange="recalc();" onkeyup="recalc();" type="range" min="0" max="0" step="1">
                            <span id="wait-9-min" class="pull-left text-muted"></span>
                            <span id="wait-9-value"></span>
                            <span id="wait-9-max" class="pull-right text-muted"></span>
                        </td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-9-fatigue-before" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-center">
                            <br>
                            <input id="distance-9-input" style="display: inline;" onchange="recalc();" onkeyup="recalc();" type="range" min="0" max="0" step="0.01">
                            <span id="distance-9-min" class="pull-left text-muted"></span>
                            <span id="distance-9-value"></span>
                            <span id="distance-9-max" class="pull-right text-muted"></span>
                        </td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-9-fatigue-after" style="font-size:140%;">&nbsp;</span></b></td>
                        <td class="text-right" style="vertical-align:middle;"><b><span id="result-9-time" style="font-size:140%;">&nbsp;</span></b></td>
                    </tr>
                    </tbody>
                </table>
                <p><small>* Be aware that there is <b>no benefit</b> in waiting for fatigue to decay <b>below 10 minutes</b></small></p>
                <br>
            </div>

    </div>

    </div>
    </div> <!-- /widget-content -->
    <!-- Content -->
    <script src="assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="assets/js/plugins/form-sliders.js"></script>

    <script src="assets/js/jfc.js"></script>


@stop

@section('jqueryreadyfunction')
    readjust();
    FormSliders.initFormSliders();

@stop