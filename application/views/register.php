<div class="row">
    <div class="col-md-4">
        <?php
        echo validation_errors();
        echo form_open_multipart('portfolio/verify_register');
        ?>
            <div class="form-group">
                <label for="UserId">Username:</label>
                <input class="form-control" type="text" size="20" id="UserId" name="UserId" required/><br/>
            </div>
            <div class="form-group">
                <label for="Player">Name:</label>
                <input class="form-control" type="text" size="20" name="Player" required/><br/>
            </div>
            <div class="form-group">
                <label for="Password">Password:</label>
                <input class="form-control" type="password" size="60" name="Password" required/><br/>
            </div>
            <div class="form-group">
                <label for="Avatar">Avatar Image:</label>
                <input type="file" id="Avatar" name="Avatar" required>
            </div>
            <button class="btn btn-primary" type="submit">Register</button>
        </form>
    </div>
</div>