@extends('dashboard.layouts.main')


@section('content')
<div class="row">
    <div class="col-lg-3">
        <div class="widget style1 blue-bg">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa icon-users fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Accounts </span>
                    <h2 class="font-bold">6</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="widget style1 navy-bg">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa icon-user fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Users</span>
                    <h2 class="font-bold">20</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="widget style1 lazur-bg">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-envelope-o fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> New messages </span>
                    <h2 class="font-bold">5</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="widget style1 yellow-bg">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-bell-o fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Notifications </span>
                    <h2 class="font-bold">2</h2>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-lg-8">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div>
                                        <span class="pull-right text-right">
                                        <small>Overall Kill / Death ration : <strong>0.78</strong></small>
                                            <br/>
                                            All sales: 162,862
                                        </span>
                    <h3 class="font-bold no-margins">
                        Recent Killboard Activity
                    </h3>
                </div>

                <div class="m-t-sm">

                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <canvas id="lineChart" height="150"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-hover margin bottom">
                                <thead>
                                <tr>
                                    <th >When</th>
                                    <th>Victim</th>
                                    <th>Loss</th>
                                    <th class="text-center">Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="text-center">16 Jun 2014</td>
                                    <td> Mad Beauty</td>
                                    <td>Orthorus</td>
                                    <td class="text-center"><span class="label label-primary">$483.00</span></td>

                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td> Wardrobes
                                    </td>
                                    <td class="text-center small">10 Jun 2014</td>
                                    <td class="text-center"><span class="label label-primary">$327.00</span></td>

                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td> Set of tools
                                    </td>
                                    <td class="text-center small">12 Jun 2014</td>
                                    <td class="text-center"><span class="label label-warning">$125.00</span></td>

                                </tr>
                                <tr>
                                    <td class="text-center">4</td>
                                    <td> Panoramic pictures</td>
                                    <td class="text-center small">22 Jun 2013</td>
                                    <td class="text-center"><span class="label label-primary">$344.00</span></td>
                                </tr>
                                <tr>
                                    <td class="text-center">5</td>
                                    <td>Phones</td>
                                    <td class="text-center small">24 Jun 2013</td>
                                    <td class="text-center"><span class="label label-primary">$235.00</span></td>
                                </tr>
                                <tr>
                                    <td class="text-center">6</td>
                                    <td>Monitors</td>
                                    <td class="text-center small">26 Jun 2013</td>
                                    <td class="text-center"><span class="label label-primary">$100.00</span></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>

                <div class="m-t-md">
                    <small class="pull-right">
                        <i class="fa fa-clock-o"> </i>
                        Update on 16.07.2015
                    </small>
                    <small>
                        <strong>Analysis of Kills and Losses:</strong> This chart only includes data pulled from the API
                    </small>
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-4">

        <div class="widget style1 gray-bg">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa icon-bulb fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Total Skill Points </span>
                    <h2 class="font-bold">458,000</h2>
                </div>
            </div>
        </div>

        <div class="widget style1 gray-bg">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa icon-wallet fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Total Wealth </span>
                    <h2 class="font-bold">378,506.56B ISK</h2>
                </div>
            </div>
        </div>

        <div class="widget style1 gray-bg">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa  icon-social-dropbox fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Total Asset Value </span>
                    <h2 class="font-bold">264,506.56B ISK</h2>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="row">
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Accounts</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="feed-activity-list">

                    <div class="feed-element">
                        <div>
                            <small class="pull-right text-navy">1m ago</small>
                            <strong>Monica Smith</strong>
                            <div>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum</div>
                        </div>
                    </div>

                    <div class="feed-element">
                        <div>
                            <small class="pull-right">2m ago</small>
                            <strong>Jogn Angel</strong>
                            <div>There are many variations of passages of Lorem Ipsum available</div>
                        </div>
                    </div>

                    <div class="feed-element">
                        <div>
                            <small class="pull-right">5m ago</small>
                            <strong>Jesica Ocean</strong>
                            <div>Contrary to popular belief, Lorem Ipsum</div>
                        </div>
                    </div>

                    <div class="feed-element">
                        <div>
                            <small class="pull-right">5m ago</small>
                            <strong>Monica Jackson</strong>
                            <div>The generated Lorem Ipsum is therefore </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Characters</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="feed-activity-list">

                    <div class="feed-element">
                        <div>
                            <small class="pull-right text-navy">1m ago</small>
                            <strong>Monica Smith</strong>
                            <div>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum</div>
                            <small class="text-muted">Today 5:60 pm - 12.06.2014</small>
                        </div>
                    </div>

                    <div class="feed-element">
                        <div>
                            <small class="pull-right">2m ago</small>
                            <strong>Jogn Angel</strong>
                            <div>There are many variations of passages of Lorem Ipsum available</div>
                            <small class="text-muted">Today 2:23 pm - 11.06.2014</small>
                        </div>
                    </div>

                    <div class="feed-element">
                        <div>
                            <small class="pull-right">5m ago</small>
                            <strong>Jesica Ocean</strong>
                            <div>Contrary to popular belief, Lorem Ipsum</div>
                            <small class="text-muted">Today 1:00 pm - 08.06.2014</small>
                        </div>
                    </div>

                    <div class="feed-element">
                        <div>
                            <small class="pull-right">5m ago</small>
                            <strong>Monica Jackson</strong>
                            <div>The generated Lorem Ipsum is therefore </div>
                            <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                        </div>
                    </div>


                    <div class="feed-element">
                        <div>
                            <small class="pull-right">5m ago</small>
                            <strong>Anna Legend</strong>
                            <div>All the Lorem Ipsum generators on the Internet tend to repeat </div>
                            <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                        </div>
                    </div>
                    <div class="feed-element">
                        <div>
                            <small class="pull-right">5m ago</small>
                            <strong>Damian Nowak</strong>
                            <div>The standard chunk of Lorem Ipsum used </div>
                            <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                        </div>
                    </div>
                    <div class="feed-element">
                        <div>
                            <small class="pull-right">5m ago</small>
                            <strong>Gary Smith</strong>
                            <div>200 Latin words, combined with a handful</div>
                            <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Messages</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="feed-activity-list">

                    <div class="feed-element">
                        <div>
                            <small class="pull-right text-navy">1m ago</small>
                            <strong>Monica Smith</strong>
                            <div>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum</div>
                            <small class="text-muted">Today 5:60 pm - 12.06.2014</small>
                        </div>
                    </div>

                    <div class="feed-element">
                        <div>
                            <small class="pull-right">2m ago</small>
                            <strong>Jogn Angel</strong>
                            <div>There are many variations of passages of Lorem Ipsum available</div>
                            <small class="text-muted">Today 2:23 pm - 11.06.2014</small>
                        </div>
                    </div>

                    <div class="feed-element">
                        <div>
                            <small class="pull-right">5m ago</small>
                            <strong>Jesica Ocean</strong>
                            <div>Contrary to popular belief, Lorem Ipsum</div>
                            <small class="text-muted">Today 1:00 pm - 08.06.2014</small>
                        </div>
                    </div>

                    <div class="feed-element">
                        <div>
                            <small class="pull-right">5m ago</small>
                            <strong>Monica Jackson</strong>
                            <div>The generated Lorem Ipsum is therefore </div>
                            <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                        </div>
                    </div>


                    <div class="feed-element">
                        <div>
                            <small class="pull-right">5m ago</small>
                            <strong>Anna Legend</strong>
                            <div>All the Lorem Ipsum generators on the Internet tend to repeat </div>
                            <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                        </div>
                    </div>
                    <div class="feed-element">
                        <div>
                            <small class="pull-right">5m ago</small>
                            <strong>Damian Nowak</strong>
                            <div>The standard chunk of Lorem Ipsum used </div>
                            <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                        </div>
                    </div>
                    <div class="feed-element">
                        <div>
                            <small class="pull-right">5m ago</small>
                            <strong>Gary Smith</strong>
                            <div>200 Latin words, combined with a handful</div>
                            <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>

@endsection


@section('scripts')

    <script>
        $(document).ready(function() {

            var lineData = {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [
    {
    label: "Example dataset",
    fillColor: "rgba(250,170,170,0.5)",
    strokeColor: "rgba(250,170,170,1)",
    pointColor: "rgba(250,170,170,1)",
    pointStrokeColor: "#fff",
    pointHighlightFill: "#fff",
    pointHighlightStroke: "rgba(250,170,170,1)",
    data: [65, 59, 40, 51, 36, 25, 40]
    },
    {
    label: "Example dataset",
    fillColor: "rgba(26,179,148,0.5)",
    strokeColor: "rgba(26,179,148,0.7)",
    pointColor: "rgba(26,179,148,1)",
    pointStrokeColor: "#fff",
    pointHighlightFill: "#fff",
    pointHighlightStroke: "rgba(26,179,148,1)",
    data: [48, 48, 60, 39, 56, 37, 30]
    }
    ]
    };

    var lineOptions = {
    scaleShowGridLines: true,
    scaleGridLineColor: "rgba(0,0,0,.05)",
    scaleGridLineWidth: 1,
    bezierCurve: true,
    bezierCurveTension: 0.4,
    pointDot: true,
    pointDotRadius: 4,
    pointDotStrokeWidth: 1,
    pointHitDetectionRadius: 20,
    datasetStroke: true,
    datasetStrokeWidth: 2,
    datasetFill: true,
    responsive: true,
    };


    var ctx = document.getElementById("lineChart").getContext("2d");
    var myNewChart = new Chart(ctx).Line(lineData, lineOptions);

    });
    </script>

    @endsection