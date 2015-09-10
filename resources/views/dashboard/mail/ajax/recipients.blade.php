<div class="project-list">

    <table class="table table-hover">
        <tbody>
            @foreach($alliances as $alliance)
            <tr>
                <td><img alt="image" class="img-circle" src="https://imageserver.eveonline.com/Alliance/{{$alliance->allianceID}}_32.png" /></td>
                <td>{{$alliance->shortName}}</td>
                <td>{{$alliance->name}}</td>
            </tr>
            @endforeach

            @foreach($corportations as $corporation)
                <tr>
                    <td><img alt="image" class="img-circle"  src="https://imageserver.eveonline.com/Corporation/{{$corporation->corporationID}}_32.png" /></td>
                    <td>{{$corporation->ticker}}</td>
                    <td>{{$corporation->corporationName}}</td>
                </tr>
            @endforeach

            @foreach($mailinglists as $mailinglist)
                <tr>
                    <td></td>
                    <td colspan="2">{{$mailinglist}}</td>
                </tr>
            @endforeach

            @foreach($characters as $character)
                <tr>
                    <td><img alt="image" class="img-circle"  src="https://imageserver.eveonline.com/Character/{{$character->characterID}}_32.jpg" /></td>
                    <td colspan="2">{{$character->characterName}}</td>
                </tr>
            @endforeach






        </tbody>
    </table>
</div>