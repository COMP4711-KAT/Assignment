<div class="row">
    <div class="col-md-4">
        <h2>Player Cash: {cash}</h2>
        <h2>Player Equity: {equity}</h2>
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

<div class="row">
    <div class="col-md-12">
        <h1>Buy & Sell Stocks</h1>
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
                <form action="/agent/exchange" method="post">
                    <td><input id="stockValue" name="value" type="number" value="{value}" readonly/></td>
                    <td>
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