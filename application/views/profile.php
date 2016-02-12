<div class="row">
    <div class="col-md-4">
        <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Select Player
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                {player_names}
                <li><a href="/profile/{Player}">{Player}</a></li>
                {/player_names}
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <h1>History of Transactions</h1>
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

</div>

<div class="row">
    <div class="col-md-12">
        <h1>Current Holdings</h1>
        <table class="table">
            <tr>
                <th>Stock</th>
                <th>Quantity</th>
            </tr>
            {stocks}
            <tr>
                <td>{name}</td>
                <td>{value}</td>
            </tr>
            {/stocks}
        </table>
    </div>
</div>