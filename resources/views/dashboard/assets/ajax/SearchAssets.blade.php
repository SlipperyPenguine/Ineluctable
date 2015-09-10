{{--Initial variable assignments--}}
@if ($divsdeep = 0) @endif
@if ($prevlocation = 0) @endif

@for ($i = 0; $i < count($assetarray); $i++)

    @if(($divsdeep == 0) && ($assetarray[$i]->locationID != $prevlocation))

        @if($i != 0)</div></div> @endif

        @if ($prevlocation = $assetarray[$i]->locationID) @endif
        <div class="asset">
            <div class="asset-title">
                <h5>{{$assetarray[$i]->locationName}}</h5>
                <div class="asset-tools"></div>
            </div>
            <div class="asset-content">
                <div class="row">
                    <div class="col-md-1"><h5>Category</h5></div>
                    <div class="col-md-2"><h5>Group</h5></div>
                    <div class="col-md-3"><h5>Type</h5></div>
                    <div class="col-md-2"><h5>Location</h5></div>
                    <div class="col-md-1"><h5>Quantity</h5></div>
                    @if($showcharactername)<div class="col-md-1"><h5>Character</h5></div>@endif
</div>

<div class="row assetrow">
<div class="col-md-1">{{$assetarray[$i]->categoryName}}</div>
<div class="col-md-2">{{$assetarray[$i]->groupName}}</div>
<div class="col-md-3"><img alt="image" height="24" class="img-rounded" src="https://image.eveonline.com/Type/{{$assetarray[$i]->typeID}}_32.png" /> {{$assetarray[$i]->typeName}}</div>
<div class="col-md-2">{{$assetarray[$i]->flagText}}</div>
<div class="col-md-1">{{$assetarray[$i]->quantity}}</div>
    @if($showcharactername)<div class="col-md-1">{{$assetarray[$i]->name}}</div>@endif
</div>

@else
<div class="row assetrow">
<div class="col-md-1">{{$assetarray[$i]->categoryName}}</div>
<div class="col-md-2">{{$assetarray[$i]->groupName}}</div>
<div class="col-md-3"><img alt="image" height="24" class="img-rounded" src="https://image.eveonline.com/Type/{{$assetarray[$i]->typeID}}_32.png" /> {{$assetarray[$i]->typeName}}</div>
<div class="col-md-2">{{$assetarray[$i]->flagText}}</div>
<div class="col-md-1">{{$assetarray[$i]->quantity}}</div>
@if(($showcharactername) &&($divsdeep == 0)) <div class="col-md-1">{{$assetarray[$i]->name}}</div> @endif
</div>
@endif
{{--check for last item and close divs--}}
@if ($i == count($assetarray)-1)
{{--do closing divs back to start--}}
@for ($j = 1; $j <= $divsdeep; $j++)
</div>
@endfor

</div>
</div>
@elseif ($assetarray[$i+1]->parentItemID == $assetarray[$i]->parentItemID)
{{--same parent do nothing!--}}
@elseif ($assetarray[$i+1]->parentItemID == $assetarray[$i]->itemID)
<div class="asset-content">

{{--Initial variable assignments--}}
@if ($divsdeep++) @endif

@elseif($assetarray[$i+1]->parentItemID == 0)
{{--do closing divs back to start--}}
@for ($j = 1; $j <= $divsdeep; $j++)
</div>
@endfor

{{--Initial variable assignments--}}
@if ($divsdeep=0) @endif

@else
@if ($lookback = 1) @endif

@while(($divsdeep>0) && ($assetarray[$i+1]->parentItemID != $assetarray[$i+1-$lookback]->itemID))
@if ($lookback++) @endif
@if ($divsdeep--) @endif
</div>
@endwhile
@endif

@endfor








