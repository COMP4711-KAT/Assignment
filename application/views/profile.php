<div class="row">
    <div class="col-md-4">
        <img src="{player_avatar}" class="img-circle" alt="Responsive image" />
    </div>
    <div class="col-md-4">
        <h2>Player Cash: {cash}</h2>
    </div>
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
        <h1>Stocks Held</h1>
        <table class="table">
            <tr>
                <th>Stock</th>
                <th>Amount</th>
            </tr>
            {stocks_held}
            <tr>
                <td>{stock}</td>
                <td>{amount}</td>
            </tr>
            {/stocks_held}
        </table>
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
                <th>Transaction</th>
                <th>Quantity</th>
            </tr>
            {transactions}
            <tr>
                <td>{DateTime}</td>
                <td>{Player}</td>
                <td>{Stock}</td>
                <td>{Trans}</td>
                <td>{Quantity}</td>
            </tr>
            {/transactions}
        </table>
    </div>
</div>
