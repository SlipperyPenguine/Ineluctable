
  <div class="col-md-6">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>Asset Search <small>Enter Search criteria</small></h5>
        <div class="ibox-tools"></div>
      </div>
      <div class="ibox-content">

        <form method="post">
          <input type="hidden" id="characterID" name="characterID" value="{{$characterID}}">
          <select class="form-control" id="searchinput" name="searchinput"  multiple="multiple"></select>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>Asset Filter <small>Enter Filter criteria</small></h5>
        <div class="ibox-tools"></div>
      </div>
      <div class="ibox-content">
        <input type="text" class="form-control" id="filterinput" name="filterinput" >
      </div>
    </div>
  </div>

  <div class="col-md-12">

    <div id="result">
      <div class="asset-list">
        @foreach($locations as $location)
          <div id="{{$location->locationID}}" class="asset collapsed">
            <div class="asset-title" onclick="LocationClicked({{$location->locationID}});">
              <h5>{{$location->locationName}} ({{$location->AssetCount}})</h5>
              <div class="asset-tools">
                <a class="assetcollapse-link">
                  <i class="fa fa-chevron-up"></i>
                </a>
              </div>
            </div>
            <div class="asset-content">empty</div>
          </div>

        @endforeach
      </div>
    </div>

  </div>


<script>

  function LocationClicked(LocationID)
  {
    var asset = $('#'+LocationID);
    var button = asset.find('i');
    var content = asset.find('div.asset-content');

    //get id from the asset div
    if(!asset.hasClass('border-bottom'))
    {
      if(content.text()=='empty') {
        var id = asset.attr('id');
        content.html('<br><p class="lead text-center"><i class="fa fa-cog fa fa-spin"></i> Loading assets...</p>')
                .load('{{ URL::asset('dashboard/character/')}}/{{$characterID}}/assets/AjaxGetLocationAssets/'  + id);
      }
    }


    content.slideToggle(200);
    button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
    asset.toggleClass('').toggleClass('border-bottom');
    setTimeout(function () {
      asset.resize();
      asset.find('[id^=map-]').resize();
    }, 50);
  }

  function ShowAssetContents(AssetID)
  {
    var asset = $('#'+AssetID);
    var button = asset.find('i');
    var content = $('#ac'+AssetID);

    if(content.text()=='empty') {
      content.html('<br><p class="lead text-center"><i class="fa fa-cog fa fa-spin"></i> Loading assets...</p>')
              .load('{{ URL::asset('dashboard/assets/AjaxGetAssetsContents/')}}/' + AssetID);
    }

    content.slideToggle(200);
    button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
    //asset.toggleClass('').toggleClass('border-bottom');


  }

  $(document).ready(function ()
  {

    $("#filterinput").on("input", function(e) {
      var txt = $('#filterinput').val();

      $( ".assetrow" ).hide();
      $( ".assetrow" ).filter( 'div:contains("'+txt+'")' ).show();


    });

  });

  $("#searchinput").select2({
    ajax: {
      url: "{{ action('AssetController@AjaxItemSearch') }}",
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          q: params.term, // search term
          page: params.page
        };
      },
      processResults: function (data) {
        // parse the results into the format expected by Select2.
        // since we are using custom formatting functions we do not need to
        // alter the remote JSON data
        return {
          results: data
        };
      },
      cache: true
    },

    minimumInputLength: 3

  });


  // Listen for when the select2() emits a change, and perform the search
  $("#searchinput").on("change", function(e) {
    console.log($("#searchinput").val());

    if ($("#searchinput").val()) { // Don't try and search for nothing

      $("div#result").html("<i class='fa fa-cog fa-spin'></i> Loading...");
      $("div#result-box").fadeIn("slow");

      $.ajax({
        type: 'post',
        url: "{{ action('AssetController@PostSearchCharacterAssets') }}",
        data: {
          '_token' : '{{Session::token()}}',
          'characterID' : '{{$characterID}}}',
          'items': $("#searchinput").val()
        },
        success: function(result){
          $("div#result").html(result);
          //$("table#datatable").dataTable({ paging:false });
        },
        error: function(xhr, textStatus, errorThrown){
          console.log(xhr);
          console.log(textStatus);
          console.log(errorThrown);
        }
      });
    }
  })
</script>