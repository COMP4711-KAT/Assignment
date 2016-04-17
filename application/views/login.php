<div class="row">
    <div class="col-md-4">
        <?php echo form_open('portfolio/verify_login'); ?>
            <div class="form-group">
                <label for="UserId">Username:</label>
                <input class="form-control" type="text" id="UserId" name="UserId"/><br/>
            </div>
            <div class="form-group">
                <label for="Password">Password:</label>
                <input class="form-control" type="password" name="Password" /><br/>
            </div>
            <button class="btn btn-primary" type="submit">Submit</button>
        </form>
    </div>
</div>