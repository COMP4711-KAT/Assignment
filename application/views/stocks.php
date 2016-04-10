<div class="row">
    <div class="col-md-4">
        <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Select Stock
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                {stocks_list}
                <li><a href="/stock/{code}">{name}</a></li>
                {/stocks_list}
            </ul>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <h1>History of Stocks</h1>
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

</div>

<div class="row">
    <div class="col-md-12">
        <h1>Transactions</h1>
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