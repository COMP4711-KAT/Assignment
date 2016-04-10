<div class="row">
    <div class="col-md-4">
        <table class="table">
            <tr>
                <th>Player</th>
                <th>Cash</th>
            </tr>
            {players}
            <tr>
                <td><a href="profile/{Player}">{Player}</a></td>
                <td>{Cash}</td>
            </tr>
            {/players}
        </table>
    </div>
    <div class="col-md-4">
        <table class="table">
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Value</th>
                <th>Link</th>
            </tr>
            {stockscsv}
            <tr>
                <td>{name}</td>
                <td>{category}</td>
                <td>{value}</td>
                <td><a href="/stock/{code}">Stock History</a></td>
            </tr>
            {/stockscsv}
        </table>
    </div>
</div>