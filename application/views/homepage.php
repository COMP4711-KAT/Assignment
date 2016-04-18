<div class="row">
    <div class="col-md-6">
        <h2>{player_name}</h2>
        <img src="{player_avatar}" class="img-circle" alt="Responsive image" />
    </div>
    <div class="col-md-6">
        <h5>Instructions:</h5>
        <p>1) Login or Register and be eligible to play in the stock exchange!</p>
        <p>2) Go the your portfolio page and click on stocks to buy or sell!</p>
        <p>3) RULE THE MARKET!</p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3 class="text-primary" >Round: {round}</h3>
        <h3 class="text-info">State: {state}</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <h1>Recent Movements</h1>
        <table class="table">
            <tr>
                <th>Sequence</th>
                <th>Date & Time</th>
                <th>Code</th>
                <th>Action</th>
                <th>Amount</th>
            </tr>
            {movement}
            <tr>
                <td>{seq}</td>
                <td>{datetime}</td>
                <td>{code}</td>
                <td>{action}</td>
                <td>{amount}</td>
            </tr>
            {/movement}
        </table>
    </div>
    <div class="col-md-6">
        <h1>Recent Transactions</h1>
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
    <div class="col-md-6">
        <h1>Players</h1>
        <table class="table">
            <tr>
                <th></th>
                <th>Player</th>
                <th>Cash</th>
                <th>Equity</th>
            </tr>
            {players}
            <tr>
                <td><img width="30" src="{Avatar}" /></td>
                <td><a href="profile/{Player}">{Player}</a></td>
                <td>{Cash}</td>
                <td>{Equity}</td>
            </tr>
            {/players}
        </table>
    </div>
    <div class="col-md-6">
        <h1>Active Stocks</h1>
        <table class="table">
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Category</th>
                <th>Value</th>
                <th>Link</th>
            </tr>
            {stockscsv}
            <tr>
                <td>{code}</td>
                <td>{name}</td>
                <td>{category}</td>
                <td>{value}</td>
                <td><a href="/stock/{code}">Stock History</a></td>
            </tr>
            {/stockscsv}
        </table>
    </div>
</div>
