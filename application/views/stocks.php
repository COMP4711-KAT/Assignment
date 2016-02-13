<div class="row">
    <div class="col-md-4">
        <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Select Stock
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                {stocks_list}
                <li><a href="/stock/{Code}">{Code}</a></li>
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
                <th>Date & Time</th>
                <th>Code</th>
                <th>Action</th>
                <th>Amount</th>
            </tr>
            {stocks}
            <tr>
                <td>{Datetime}</td>
                <td>{Code}</td>
                <td>{Action}</td>
                <td>{Amount}</td>
            </tr>
            {/stocks}
        </table>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <h1>Transactions</h1>
        <table class="table">
            <tr>
                <th>Datetime</th>
                <th>Player</th>
                <th>Trans</th>
                <th>Quantity</th>
            </tr>
            {transactions}
            <tr>
                <td>{DateTime}</td>
                <td>{Player}</td>
                <td>{Trans}</td>
                <td>{Quantity}</td>
            </tr>
            {/transactions}
        </table>
    </div>
</div>