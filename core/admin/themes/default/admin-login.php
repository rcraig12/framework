<?php fwHead(); ?>
<div class="content">
  <h1>Login</h1>
  <form method="post" action="/fw-admin/login">
        <!-- CSRF Token -->
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

        <!-- Username Input -->
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $username ?? ''; ?>" required>
        <br>

        <!-- Password Input -->
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>

        <!-- Submit Button -->
        <button type="submit">Login</button>
    </form>
</div>
<?php fwFoot(); ?>