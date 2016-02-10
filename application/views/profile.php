<div class="row">
    <div class="col-md-4">
        <table class="table">
            <tr>
                <th>Date & Time</th>
                <th>Player</th>
                <th>Stock</th>
                <th>Transfer Type</th>
                <th>Quantity</th>
            </tr>
            {players}
            <tr>
                <td>{DateTime}</td>
                <td>{Player}</td>
                <td>{Stock}</td>
                <td>{Trans}</td>
                <td>{Quantity}</td>
            </tr>
            {/players}
        </table>
    </div>


    <div class="col-md-4">
        <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Select Player
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                {player_names}
                <li><a href="./{Player}">{Player}</a></li>
                {/player_names}
            </ul>
        </div>
    </div>
</div>