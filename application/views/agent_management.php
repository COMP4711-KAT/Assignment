{agent-info}
<div class="row">
    <div class="col-md-12">
        <form action="/agent/create" method="post">
            <div class="form-group">
                <label for="team">Team</label>
                <input class="form-control" type="text" id="team" name="team" value="{team}" required>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" type="text" id="name" name="name" value="{name}" required>
            </div>
            <button class="btn btn-primary" type="submit">{button}</button>
        </form>
    </div>
</div>