<?php
// register_process.php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']); // Plain text for now
    $role = $conn->real_escape_string($_POST['role']);

    // Check if username already exists
    $checkUser = $conn->query("SELECT * FROM Users WHERE username='$username'");
    if ($checkUser->num_rows > 0) {
        die("Username already exists. Please choose another.");
    }

    // Generate user_id based on role
    $prefix = '';
    switch ($role) {
        case 'student': $prefix = 'ST'; break;
        case 'instructor': $prefix = 'IT'; break;
        case 'labto': $prefix = 'TO'; break;
        case 'lecture': $prefix = 'L'; break;
        default: die("Invalid role selected.");
    }

    // Get next number for user_id
    $result = $conn->query("SELECT user_id FROM Users WHERE role='$role' ORDER BY user_id DESC LIMIT 1");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastIdNum = (int) filter_var($row['user_id'], FILTER_SANITIZE_NUMBER_INT);
        $newIdNum = $lastIdNum + 1;
    } else {
        $newIdNum = 1;
    }
    $user_id = $prefix . $newIdNum;

    // Insert into Users table
    $sqlUser = "INSERT INTO Users (user_id, username, password, role, status) VALUES ('$user_id', '$username', '$password', '$role', 'active')";
    if (!$conn->query($sqlUser)) {
        die("Error inserting user: " . $conn->error);
    }

    // Insert into role-specific table
    switch ($role) {
        case 'student':
            $student_id = $conn->real_escape_string($_POST['student_id']);
            $name = $conn->real_escape_string($_POST['student_name']);
            $semester = (int)$_POST['semester'];

            // Check Student_ID uniqueness
            $checkStudent = $conn->query("SELECT * FROM Student WHERE Student_ID='$student_id'");
            if ($checkStudent->num_rows > 0) {
                die("Student ID already exists. Please use a unique Student ID.");
            }

            $sqlStudent = "INSERT INTO Student (Student_ID, user_id, Name, Semester) VALUES ('$student_id', '$user_id', '$name', $semester)";
            if (!$conn->query($sqlStudent)) {
                die("Error inserting student: " . $conn->error);
            }
            break;

        case 'instructor':
            $name = $conn->real_escape_string($_POST['instructor_name']);
            $sqlInstructor = "INSERT INTO Instructor (user_id, Name) VALUES ('$user_id', '$name')";
            if (!$conn->query($sqlInstructor)) {
                die("Error inserting instructor: " . $conn->error);
            }
            break;

        case 'labto':
            $name = $conn->real_escape_string($_POST['labto_name']);
            $sqlLabTO = "INSERT INTO Lab_TO (user_id, Name) VALUES ('$user_id', '$name')";
            if (!$conn->query($sqlLabTO)) {
                die("Error inserting Lab TO: " . $conn->error);
            }
            break;

        case 'lecture':
            $name = $conn->real_escape_string($_POST['lecture_name']);
            $department = $conn->real_escape_string($_POST['department']);
            $sqlLecture = "INSERT INTO Lecture (user_id, Name, Department) VALUES ('$user_id', '$name', '$department')";
            if (!$conn->query($sqlLecture)) {
                die("Error inserting lecture: " . $conn->error);
            }
            break;
    }

    // Registration successful
    header("Location: login.php?registered=1");
    exit();
}
?>

