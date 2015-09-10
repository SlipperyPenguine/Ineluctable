<div class="footer">
    <div class="pull-right">
        @if($serverstatus->serverOpen=='True')
            Tranquility is currently <strong>Online</strong> with <strong>{{$serverstatus->onlinePlayers}}</strong> users
        @else
            Tranquility is currently <strong>Offline</strong>
        @endif
    </div>
    <div>
        <strong>Ineluctable</strong>  Eve Online alliance
    </div>
</div>
