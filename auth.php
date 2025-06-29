<?php
// auth.php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $role = $conn->real_escape_string($_POST['role']);

    $sql = "SELECT * FROM Users WHERE username='$username' AND password='$password' AND role='$role' AND status='active'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect to role-specific dashboard
        switch ($role) {
            case 'student':
                header("Location: student_dashboard.php");
                break;
            case 'instructor':
                header("Location: instructor_dashboard.php");
                break;
            case 'labto':
                header("Location: labto_dashboard.php");
                break;
            case 'lecture':
                header("Location: lecture_dashboard.php");
                break;
            default:
                header("Location: login.php?error=Invalid role");
        }
        exit();
    } else {
        header("Location: login.php?error=Invalid credentials");
        exit();
    }
}
?>
