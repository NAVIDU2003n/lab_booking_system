<?php
// lecture_dashboard.php
include 'config.php';

// Only allow lectures
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'lecture') {
    header("Location: login.php");
    exit();
}

include 'header.php';
echo '<div class="top-right"><a href="logout.php">Logout</a></div>';
echo "<h2>Lecture Dashboard</h2>";

/* 1. All Labs */
echo "<h3>All Labs</h3>";
$labs = $conn->query("
    SELECT l.Lab_ID, l.Name, l.Type, l.Capacity, t.Name AS LabTO
    FROM lab l
    LEFT JOIN lab_to t ON l.Lab_TO_ID = t.Lab_TO_ID
    ORDER BY l.Lab_ID
");
if ($labs && $labs->num_rows > 0) {
    echo "<table border='1' cellpadding='5'><tr>
        <th>Lab ID</th><th>Name</th><th>Type</th><th>Capacity</th><th>Lab TO</th>
    </tr>";
    while ($row = $labs->fetch_assoc()) {
        echo "<tr>
            <td>{$row['Lab_ID']}</td>
            <td>" . htmlspecialchars($row['Name']) . "</td>
            <td>" . htmlspecialchars($row['Type']) . "</td>
            <td>{$row['Capacity']}</td>
            <td>" . htmlspecialchars($row['LabTO']) . "</td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No labs found.</p>";
}

/* 2. Equipment by Lab */
echo "<h3>Lab Equipment</h3>";
$equip = $conn->query("
    SELECT l.Name AS LabName, e.Name AS Equipment, e.Quantity
    FROM lab_equipment e
    JOIN lab l ON e.Lab_ID = l.Lab_ID
    ORDER BY l.Lab_ID, e.Name
");
if ($equip && $equip->num_rows > 0) {
    echo "<table border='1' cellpadding='5'><tr>
        <th>Lab</th><th>Equipment</th><th>Quantity</th>
    </tr>";
    while ($row = $equip->fetch_assoc()) {
        echo "<tr>
            <td>" . htmlspecialchars($row['LabName']) . "</td>
            <td>" . htmlspecialchars($row['Equipment']) . "</td>
            <td>{$row['Quantity']}</td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No equipment found.</p>";
}

/* 3. All Scheduled Lab Sessions */
echo "<h3>All Scheduled Lab Sessions</h3>";
$sessions = $conn->query("
    SELECT ls.Schedule_ID, l.Name AS LabName, ls.Date, ls.Start_Time, ls.End_Time, 
           ls.Remaining_Capacity, ls.Status, i.Name AS Instructor
    FROM lab_schedule ls
    JOIN lab l ON ls.Lab_ID = l.Lab_ID
    LEFT JOIN instructor i ON ls.Instructor_ID = i.Instructor_ID
    ORDER BY ls.Date DESC, ls.Start_Time DESC
");
if ($sessions && $sessions->num_rows > 0) {
    echo "<table border='1' cellpadding='5'><tr>
        <th>Schedule ID</th><th>Lab</th><th>Date</th><th>Time</th>
        <th>Instructor</th><th>Capacity</th><th>Status</th>
    </tr>";
    while ($row = $sessions->fetch_assoc()) {
        echo "<tr>
            <td>{$row['Schedule_ID']}</td>
            <td>" . htmlspecialchars($row['LabName']) . "</td>
            <td>{$row['Date']}</td>
            <td>{$row['Start_Time']} - {$row['End_Time']}</td>
            <td>" . htmlspecialchars($row['Instructor']) . "</td>
            <td>{$row['Remaining_Capacity']}</td>
            <td>" . ucfirst($row['Status']) . "</td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No scheduled sessions found.</p>";
}

/* 4. All Student Bookings */
echo "<h3>All Student Bookings</h3>";
$bookings = $conn->query("
    SELECT lb.Booking_ID, s.Name AS Student, lb.Status, l.Name AS LabName, 
           ls.Date, ls.Start_Time, ls.End_Time
    FROM lab_booking lb
    JOIN student s ON lb.Student_ID = s.Student_ID
    JOIN lab_schedule ls ON lb.Schedule_ID = ls.Schedule_ID
    JOIN lab l ON ls.Lab_ID = l.Lab_ID
    ORDER BY lb.Booking_ID DESC
");
if ($bookings && $bookings->num_rows > 0) {
    echo "<table border='1' cellpadding='5'><tr>
        <th>Booking ID</th><th>Student</th><th>Lab</th>
        <th>Date</th><th>Time</th><th>Status</th>
    </tr>";
    while ($row = $bookings->fetch_assoc()) {
        echo "<tr>
            <td>{$row['Booking_ID']}</td>
            <td>" . htmlspecialchars($row['Student']) . "</td>
            <td>" . htmlspecialchars($row['LabName']) . "</td>
            <td>{$row['Date']}</td>
            <td>{$row['Start_Time']} - {$row['End_Time']}</td>
            <td>" . ucfirst($row['Status']) . "</td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No bookings found.</p>";
}

echo "</body></html>";
?>
