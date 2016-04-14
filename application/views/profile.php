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
                <th>Sequence</th>
                <th>Date & Time</th>
                <th>Agent</th>
                <th>Player</th>
                <th>Stock</th>
                <th>Transaction</th>
                <th>Quantity</th>
            </tr>
            {transactions}
            <tr>
                <td>{seq}</td>
                <td>{datetime}</td>
                <td>{agent}</td>
                <td>{player}</td>
                <td>{stock}</td>
                <td>{trans}</td>
                <td>{quantity}</td>
            </tr>
            {/transactions}
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <h1>Current Holdings</h1>
        <table class="table">
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Category</th>
                <th>Value</th>
            </tr>
            {stocks}
            <tr>
                <td>{code}</td>
                <td>{name}</td>
                <td>{category}</td>
                <td>{value}</td>
                <td>
                    <form action="/agent/exchange" method="post">
                        <input id="stock" name="stock" type="hidden" value="{code}" />
                        <input id="quantity" name="quantity" type="number" value="1" min="0" style="width:40px"/>
                        <button id="buy" name="buy" type="submit" class="btn btn-primary">Buy</button>
                        <button id="sell" name="sell" type="submit" class="btn btn-danger">Sell</button>
                    </form>
                </td>
            </tr>
            {/stocks}
        </table>
    </div>
</div>