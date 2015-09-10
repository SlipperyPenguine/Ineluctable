<div class="row">
    <div class="col-md-1"><h5>Category</h5></div>
    <div class="col-md-2"><h5>Group</h5></div>
    <div class="col-md-3"><h5>Type</h5></div>
    <div class="col-md-2"><h5>Location</h5></div>
    <div class="col-md-1"><h5>Quantity</h5></div>
    @if($showcharactername)<div class="col-md-1"><h5>Character</h5></div>@endif
</div>
@foreach($assets as $asset)
    @if($asset->contents > 0)
        <div class="row assetrow assetwithcontents" id="{{$asset->itemID}}" onclick="ShowAssetContents({{$asset->itemID}});">
            <div class="col-md-1">{{$asset->categoryName}}</div>
            <div class="col-md-2">{{$asset->groupName}}</div>
            <div class="col-md-3"><img alt="image" height="24" class="img-rounded" src="https://image.eveonline.com/Type/{{$asset->typeID}}_32.png" /> {{$asset->typeName}}</div>
            <div class="col-md-2">{{$asset->flagText}}</div>
            <div class="col-md-1">{{$asset->quantity}}</div>
            @if($showcharactername)
                <div class="col-md-1">{{$asset->name}}</div>
            @endif
            <div class="col-md-1 pull-right"> <i class="fa fa-chevron-up"></i></div>
        </div>
        <div class="asset-content" id="ac{{$asset->itemID}}">empty</div>
    @else
        <div class="row assetrow">
            <div class="col-md-1">{{$asset->categoryName}}</div>
            <div class="col-md-2">{{$asset->groupName}}</div>
            <div class="col-md-3"><img alt="image" height="24" class="img-rounded" src="https://image.eveonline.com/Type/{{$asset->typeID}}_32.png" /> {{$asset->typeName}}</div>
            <div class="col-md-2">{{$asset->flagText}}</div>
            <div class="col-md-1">{{$asset->quantity}}</div>
            @if($showcharactername)
            <div class="col-md-1">{{$asset->name}}</div>
            @endif
        </div>
    @endif
@endforeach



