@extends('app')

@section('content')


  <div class="container">
    <!-- Example row of columns -->
    <div class="row">
      <div class="col-md-4">
        <div class="headline"><h2>API Details</h2></div>

        {!!  Form::open(array('class' => 'sky-form', 'id' => 'api-form')) !!}

        <fieldset>
          <section>
            <label class="select">
              <i></i>
             <select name="api" id="api">
                <option value="X" selected disabled>API</option>
                <option value="Account">Account</option>
                <option value="char">Character</option>
                <option value="corp">Corporation</option>
                <option value="Eve">eve</option>
                <option value="Map">Map</option>
                <option value="Server">Server</option>
              </select>

            </label>

            <label class="select">
              <i></i>
              <select name="call" id="call">
                <option value="X" selected disabled>Call</option>

              </select>

            </label>

          </section>
          <section>

              <label class="input">
                <i class="icon-append fa fa-key"></i>
                <input type="text" name="keyID" id="keyID" placeholder="API Key ID" value="3619322">
                <b class="tooltip tooltip-bottom-right">Key ID for API</b>
              </label>

            <label class="input">
              <i class="icon-append fa fa-code"></i>
              <input type="text" name="vCode" id="vCode" placeholder="Verification Code" value="YAU75QtIkox5bosnYzZZ0CaMK7X6FHf0L0V3HDMrbYAsCTMwrtRpURToCmGSPWWy">
            </label>

              <label class="input">
                <i class="icon-append fa fa-user"></i>
                <input type="text" name="characterid" id="characterid" placeholder="Character ID" value="1201180832">
              </label>

          </section>

          <section>

            <label class="input">
              <i class="icon-append fa fa-bolt"></i>
              <input type="text" name="optional1" id="optional1" placeholder="Optional Argument 1">
            </label>

            <label class="input">
              <i class="icon-append fa fa-pencil"></i>
              <input type="text" name="optional1value" id="optional1value" placeholder="Optional 1 Value">
            </label>

            <label class="input">
              <i class="icon-append fa fa-bolt"></i>
              <input type="text" name="optional2" id="optional2" placeholder="Optional Argument 2">
            </label>

            <label class="input">
              <i class="icon-append fa fa-pencil"></i>
              <input type="text" name="optional2value" id="optional2value" placeholder="Optional 2 Value">
            </label>

          </section>
        </fieldset>

        <footer>
          <button id="singlebutton" name="singlebutton" class="btn btn-block btn-primary"><i class="fa fa-check-square"></i> Run Test</button>
        </footer>



        {!!   Form::close() !!}

      </div>
      <div class="col-md-8" id="result-box" style="display: none;">
        <div class="headline"><h2>Results</h2></div>
        <div id="result">
        </div>
      </div>

    </div>
  </div>



@endsection

@section('scripts')

  <script type="text/javascript">

/*    $("select#api").select2();
    $("select#call").select2();*/

    // variable to hold request
    var request;
    // bind to the submit event of our form
    $("#api-form").submit(function(event){

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
      $("div#result").html("<i class='fa fa-cog fa-spin'></i> Processing the API Call...");
      $("div#result-box").fadeIn("slow");

      // fire off the request to /form.php
      request = $.ajax({
        url: "{{ action('DebugController@postQuery') }}",
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



  $('#api').on('change', function() {
    //alert( this.value ); // or $(this).val()

    request = $.ajax({
      url: "{{ action('DebugController@AjaxGetCallList') }}",
      type: "post",
      data: {api: $('#api').find('option:selected').text(), _token: $('input[name=_token]').val()}
    });

    // callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
      //$("div#result").html(response);
      var $el = $("#call");
      //$el.empty(); // remove old options
      $('#call option:gt(0)').remove(); // remove all options, but not the first

      var callarray = new Array();
      callarray = response.split(",");

      for (call in callarray ) {
        $el.append($("<option></option>")
                .attr("value", callarray[call]).text(callarray[call]));

      }


    });

    // callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
      // log the error to the console
      alert ( 'something failed: '+ errorThrown);
      console.error(
              "The following error occured: " + textStatus, errorThrown
      );
    });

  });

  </script>

@endsection
