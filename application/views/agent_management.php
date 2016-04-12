{message}
<div class="row">
    <div class="col-md-12">
        <form action="/agent/create" method="post">
            <div class="form-group">
                <label for="team">Team</label>
                <input class="form-control" type="text" id="team" name="team" value="{team}">
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" type="text" id="name" name="name" value="{name}">
            </div>
            <div class="form-group">
                <label for="frequency">Frequency</label>
                <input class="form-control" type="number" id="frequency" name="frequency" value="{frequency}">
            </div>
            <button class="btn btn-primary" type="submit">{button}</button>
        </form>
    </div>
</div>