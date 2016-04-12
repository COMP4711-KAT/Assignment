<?php echo form_open_multipart('portfolio/verify_register'); ?>
    <label for="UserId">Username:</label>
    <input type="text" size="20" id="UserId" name="UserId"/><br/>
    <label for="Avatar">Avatar Image:</label>
    <input type="file" id="Avatar" name="Avatar">
    <label for="Password">Password:</label>
    <input type="password" size="60" name="Password" /><br/>
    <input type="submit" value="Login"/>
</form>