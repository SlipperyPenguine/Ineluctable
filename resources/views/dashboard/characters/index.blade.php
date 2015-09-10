@extends('dashboard.layouts.mainwithheading')

@section('heading')Character List @endsection
@section('breadcrumbs')
    <li>
        <a href="{{ URL::asset('/home') }}">Home</a>
    </li>
    <li>
        <a href="{{ URL::asset('dashboard/home') }}">Dashboard</a>
    </li>
    <li>
        <a>Characters</a>
    </li>
    <li class="active">
        <strong>Character List</strong>
    </li>
@endsection

@section('content')

    <div class="ibox">
        <div class="ibox-title">
            <h5>All characters assigned to your account</h5>
        </div>
        <div class="ibox-content">
            <div class="project-list">

                <table class="table table-hover dataTables-characters">
                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Character</th>
                        <th>Location</th>
                        <th>Ship</th>
                        <th >Isk</th>
                        <th>SP</th>
                        <th>Sec</th>
                        <th>%</th>
                        <th>Training</th>
                        <th>%</th>
                        <th>Skill Queue</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($characters as $character)

                    <tr>
                        <td class="project-status">
                            @if(isset($character['skillintraining']) && ($character['skillintraining']->skillInTraining==1))
                            <span class="label label-primary">Training</span>
                                @endif
                        </td>
                        <td class="charlist-char">
                            <img alt="image" class="img-circle" src="https://image.eveonline.com/Character/{{$character['info']->characterID}}_64.jpg" />
                        </td>
                        <td class="project-title">
                            <a href="{{ URL::asset('dashboard/characters/') }}/{{$character['info']->characterID}}">{{ $character['info']->characterName  }}</a>
                            <br/>
                            <small>{{ $character['info']->corporation }} @if($character['info']->alliance) <br> ({{$character['info']->alliance}})@endif</small>
                        </td>
                        <td class="project-title">
                            <a href="{{$character['dotlan']}}" target="_blank">{{ $character['info']->lastKnownLocation  }}</a>
                            <br/>
                            <small>{{$character['region']->itemName}}</small>
                        </td>
                        <td class="project-title">
                            {{$character['info']->shipTypeName}}
                        </td>
                        <td class="project-actions">
                            {{number_format( $character['info']->accountBalance, 0)}} <br>
                        </td>
                        <td class="project-actions">
                            {{number_format( $character['info']->skillPoints, 0)}} <br>
                        </td>
                        <td class="project-actions">
                            {{number_format( $character['info']->securityStatus, 1)}}
                        </td>
                        <td>
                            @if(isset($character['skillintraining']) && ($character['skillintraining']->skillInTraining==1))
                                {{$character['currentskilltimetogo']}}
                            @else
                                9999999999999
                            @endif
                        </td>
                        <td class="project-completion">
                            @if(isset($character['skillintraining']) && ($character['skillintraining']->skillInTraining==1))
                            {{$character['skillintraining']->type->typeName}} {{ \ineluctable\Services\Helpers\RomanNumeralsConverter::convert( $character['skillintraining']->trainingToLevel)}} <br>
                                <small>{{$character['currentskillpercentage']}}% complete. Finishes in {{$character['skillintraining']->trainingEndTime->diffForHumans( \Carbon\Carbon::now(), true)}}</small>
                            <div class="progress progress-mini">
                                <div style="width: {{$character['currentskillpercentage']}}%;" class="progress-bar"></div>
                            </div>
                            @endif
                        </td>
                        <td>
                            @if(isset($character['skillintraining']) && ($character['skillintraining']->skillInTraining==1))
                                {{$character['skillqueuetimetogo']}}
                            @else
                                9999999999999
                            @endif
                        </td>
                        <td class="project-completion">
                            @if(isset($character['skillintraining']) && ($character['skillintraining']->skillInTraining==1))
                                <br>
                                <small>{{$character['skillqueuepercentage']}}% complete. Finishes in {{$character['lastskilltrainEndDate']->diffForHumans( \Carbon\Carbon::now(), true)}}</small>
                                <div class="progress progress-mini">
                                    <div style="width: {{$character['skillqueuepercentage']}}%;" class="progress-bar"></div>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>


            </div>
        </div>

    </div>

@endsection



@section('scripts')

        <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            $('.dataTables-characters').dataTable({
                "order": [[ 2, 'asc' ]],

                "columnDefs": [ {
                    "targets": [0,1],
                    "orderable": false
                },
                    {
                        "targets": [8,10],
                        "visible": false
                    },
                    {
                        "orderData": [8],
                        "targets": [9]

                    },
                    {
                        "orderData": [10],
                        "targets": [11]

                    }],
                responsive: false,
                "dom": 'T<"clear">lfrtip',
                "tableTools": {
                    "sSwfPath": "{{ URL::asset('js/plugins/dataTables/swf/copy_csv_xls_pdf.swf') }}"
                }
            });

        });

    </script>


@endsection