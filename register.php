<?php
// register.php
include 'header.php';
?>

<div class="container">
    <h2>Register</h2>
    <form action="register_process.php" method="POST" id="registerForm">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Role:</label><br>
        <select name="role" id="role" required onchange="toggleRoleFields()">
            <option value="">Select Role</option>
            <option value="student">Student</option>
            <option value="instructor">Instructor</option>
            <option value="labto">Lab TO</option>
            <option value="lecture">Lecture</option>
        </select><br><br>

        <div id="studentFields" style="display:none;">
            <label>Student ID:</label><br>
            <input type="text" name="student_id"><br><br>

            <label>Name:</label><br>
            <input type="text" name="student_name"><br><br>

            <label>Semester:</label><br>
            <input type="number" name="semester" min="1" max="12"><br><br>
        </div>

        <div id="instructorFields" style="display:none;">
            <label>Name:</label><br>
            <input type="text" name="instructor_name"><br><br>
        </div>

        <div id="labtoFields" style="display:none;">
            <label>Name:</label><br>
            <input type="text" name="labto_name"><br><br>
        </div>

        <div id="lectureFields" style="display:none;">
            <label>Name:</label><br>
            <input type="text" name="lecture_name"><br><br>

            <label>Department:</label><br>
            <input type="text" name="department"><br><br>
        </div>

        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>

<script>
function toggleRoleFields() {
    var role = document.getElementById('role').value;
    document.getElementById('studentFields').style.display = (role === 'student') ? 'block' : 'none';
    document.getElementById('instructorFields').style.display = (role === 'instructor') ? 'block' : 'none';
    document.getElementById('labtoFields').style.display = (role === 'labto') ? 'block' : 'none';
    document.getElementById('lectureFields').style.display = (role === 'lecture') ? 'block' : 'none';
}
</script>

</body>
</html>

