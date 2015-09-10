// ---------------------------------------------------------------

var indexStrategic = 0;
var indexMilitary = 0;
var indexIndustrial = 0;

var militaryLookup = [0.0, 0.6, 1.2, 1.7, 2.1, 2.5];
var industrialLookup = [0.0, 0.6, 1.2, 1.7, 2.1, 2.5];
var strategicLookup = [0.0, 0.4, 0.6, 0.8, 0.9, 1.0];

var cycle_t1 = 5.0;
var cycle_t2 = 2.0;
var cycle_capital_ship = 5.0;
var index_capital_system = 2.0;
var vulnMax = 18.0;

// ---------------------------------------------------------------

$(document).ready(function() {
    readjust();
});

// ---------------------------------------------------------------

function hourtohuman(hour) {
    h = Math.floor(hour);
    m = Math.floor(60 * (hour - h));
    if (m == 0) {
        return h + "h";
    }
    return h + "h " + m  + "m";
}

function readjust() {

    for (i=0; i <= 5; i++) {
        $("#option-index-strategic-" + i).removeClass('btn-primary');
    }
    for (i=0; i <= indexStrategic; i++) {
        $("#option-index-strategic-" + i).addClass('btn-primary');
    }

    for (i=0; i <= 5; i++) {
        $("#option-index-military-" + i).removeClass('btn-primary');
    }
    for (i=0; i <= indexMilitary; i++) {
        $("#option-index-military-" + i).addClass('btn-primary');
    }

    for (i=0; i <= 5; i++) {
        $("#option-index-industrial-" + i).removeClass('btn-primary');
    }
    for (i=0; i <= indexIndustrial; i++) {
        $("#option-index-industrial-" + i).addClass('btn-primary');
    }

    var f1 = Math.min(6.0, (1.0 + militaryLookup[indexMilitary] + industrialLookup[indexIndustrial] + strategicLookup[indexStrategic]));
    var f2 = Math.min(6.0, (1.0 + index_capital_system + militaryLookup[indexMilitary] + industrialLookup[indexIndustrial] + strategicLookup[indexStrategic]));

    $("#time-subcap-warmup-1").html(cycle_t1 + "m");
    $("#time-subcap-warmup-2").html(cycle_t2 + "m");

    $("#time-capital-warmup-1").html(cycle_t1 * cycle_capital_ship + "m");
    $("#time-capital-warmup-2").html(cycle_t2 * cycle_capital_ship + "m");

    $("#time-station").html(+(5.0 * f1).toFixed(2) + "m");
    $("#time-structure-1").html(+(10.0 * f1).toFixed(2) + "m");
    $("#time-structure-2").html(+(10.0 * f2).toFixed(2) + "m");

    $("#time-vuln-1").html(hourtohuman(vulnMax / f1));
    $("#time-vuln-2").html(hourtohuman(vulnMax / f2));

}

// ---------------------------------------------------------------