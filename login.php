<?php
// login.php
include 'header.php';
?>

<div class="container">
    <h2>Login</h2>
    <form action="auth.php" method="POST">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Role:</label><br>
        <select name="role" required>
            <option value="">Select Role</option>
            <option value="student">Student</option>
            <option value="instructor">Instructor</option>
            <option value="labto">Lab TO</option>
            <option value="lecture">Lecture</option>
        </select><br><br>

        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</div>

</body>
</html>
