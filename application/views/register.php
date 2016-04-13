<?php
echo validation_errors();
echo form_open_multipart('portfolio/verify_register');
?>
    <label for="UserId">Username:</label>
    <input type="text" size="20" id="UserId" name="UserId" required/><br/>
    <label for="Avatar">Avatar Image:</label>
    <input type="file" id="Avatar" name="Avatar" required>
    <label for="Player">Name:</label>
    <input type="text" size="20" name="Player" required/><br/>
    <label for="Password">Password:</label>
    <input type="password" size="60" name="Password" required/><br/>
    <input type="submit" value="Login"/>
</form>