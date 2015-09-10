@extends('dashboard.layouts.mainwithheading')

@section('heading')API Keys @endsection
@section('breadcrumbs')
    <li>
        <a href="{{ URL::asset('/home') }}">Home</a>
    </li>
    <li>
        <a href="{{ URL::asset('dashboard/home') }}">Dashboard</a>
    </li>
    <li>
        <a>Profile</a>
    </li>
    <li class="active">
        <strong>API Keys</strong>
    </li>
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Keys</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                            <tr>
                                <th>KeyID</th>
                                <th>Type</th>
                                <th>Access Mask</th>
                                <th>Expires</th>
                                <th>Characters On Key</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <p><a href="{{ action('ApiKeyController@create') }}" class="btn btn-primary">Add a New Key</a></p>
                            @foreach($apikeys as $key)

                                <tr @if ($key->isOk <> 1) class="danger" @endif>
                                    <td>{{ $key->keyID }}</td>
                                    <td>{{ $key->apiKeyInfo->type }}</td>
                                    <td>{{ $key->apiKeyInfo->accessMask }}</td>
                                    <td>{{ $key->apiKeyInfo->expires }}</td>
                                    <td>

                                        @foreach($key->characters as $char)
                                            <a href="{{ action('CharacterController@show', array('characterID' => $char->characterName)) }}">
                                            <img alt="image" class="img-circle" height="16" src="https://imageserver.eveonline.com/Character/{{$char->characterID}}_32.jpg" /> {{ $char->characterName }}
                                            </a>
                                        @endforeach

                                    </td>
                                    <td>
                                        <a href="{{ URL::asset('/dashboard/apikeys') }}/{{$key->keyID}}"  class="btn btn-default btn-xs"><i class="fa fa-cog"></i> Key Details</a>
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

        <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            $('.dataTables-example').dataTable({
                responsive: true,
                "dom": 'T<"clear">lfrtip',
                "tableTools": {
                    "sSwfPath": "{{ URL::asset('js/plugins/dataTables/swf/copy_csv_xls_pdf.swf') }}"
                }
            });

        });

    </script>


@endsection