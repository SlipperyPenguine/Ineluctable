@extends('dashboard.layouts.mainwithheading')

@section('heading')Add New API Key @endsection
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
    <li>
        <a href="{{ URL::asset('dashboard/apikeys') }}">API Keys</a>
    </li>
    <li class="active">
        <strong>New Key</strong>
    </li>
@endsection

@section('content')


    <div class="row">
        <!-- user details panel -->
        <div class="col-md-8">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>
                        <b>Add New API Key</b>
                    </h5>
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

                    {!! Form::open(array('class' => 'form-horizontal', 'id' => 'key-form'))  !!}

                    <fieldset>

                        <!-- Prepended text-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="prependedtext">Key ID</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    {!! Form::text('keyID', null, array('id' => 'keyID', 'class' => 'form-control', 'placeholder' => 'Key ID'), 'required', 'autofocus') !!}
                                </div>
                            </div>
                        </div>

                        <!-- Prepended text-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="prependedtext">Verification Code</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-magic"></i></span>
                                    {!! Form::text('vCode', null, array('id' => 'vCode', 'class' => ' form-control', 'placeholder' => 'vCode'), 'required') !!}
                                </div>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="singlebutton"></label>
                            <div class="col-md-6">
                                <button id="check-key" name="singlebutton" class="btn btn-primary">Check Key</button>
                            </div>
                        </div>

                    </fieldset>
                    </form>
                </div>

            </div>
        </div>

        <!-- user details panel -->




    <!-- user details panel -->

        <div class="col-md-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><b>Register a New API Key</b></h5>

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

                    <ul class="list-unstyled">
                        <!-- API Links -->
                        <li>Create a new <a href="https://support.eveonline.com/api/key/CreatePredefined/268435455" target="_blank"><i class="fa fa-external-link"></i> full access</a> key (recommended).</li>
                        <li>
                            The minimum access mask is 176693568, click
                            <a href="https://support.eveonline.com/api/key/CreatePredefined/176693568" target="_blank">
                                <i class="fa fa-external-link"></i>here
                            </a> to make a key with this mask.
                        </li>
                    </ul>
            </div>


        </div>
    </div>

     </div>

    <!-- results box -->
    <div class="ibox float-e-margins" id="result-box" style="display: none;">
        <div class="ibox-title">
            <h5><b>API Key Check Results</b></h5>

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
            <div id="result">
            </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

@endsection

@section('scripts')
    <script type="text/javascript">

        // variable to hold request
        var request;
        // bind to the submit event of our form
        $("#key-form").submit(function(event){

            // abort any pending request
            if (request) {
                request.abort();
            }
            // setup some local variables
            var $form = $(this);
            // let's select and cache all the fields
            var $inputs = $form.find("input, select, button, textarea");
            // serialize the data in the form
            var serializedData = $form.serialize();

            // let's disable the inputs for the duration of the ajax request
            // Note: we disable elements AFTER the form data has been serialized.
            // Disabled form elements will not be serialized.
            $inputs.prop("disabled", true);

            // Show the results box and a loader
            $("div#result").html("<i class='fa fa-cog fa-spin'></i> Loading...");
            $("div#result-box").fadeIn("slow");

            // fire off the request to /form.php
            request = $.ajax({
                url: "{{ action('ApiKeyController@ajaxcheckkey') }}",
                type: "post",
                data: serializedData
            });

            // callback handler that will be called on success
            request.done(function (response, textStatus, jqXHR){
                $("div#result").html(response);
            });

            // callback handler that will be called on failure
            request.fail(function (jqXHR, textStatus, errorThrown){
                // log the error to the console
                console.error(
                        "The following error occured: " + textStatus, errorThrown
                );
            });

            // callback handler that will be called regardless
            // if the request failed or succeeded
            request.always(function () {
                // reenable the inputs
                $inputs.prop("disabled", false);
            });

            // prevent default posting of form
            event.preventDefault();
        });
    </script>

@endsection

