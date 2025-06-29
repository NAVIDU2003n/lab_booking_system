<?php
include 'config.php';

// Ensure only students can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

include 'header.php';
echo '<div class="top-right"><a href="logout.php">Logout</a></div>';
echo "<h2>Student Dashboard</h2>";
echo "<h3>Available Labs & Details</h3>";

// Get Student_ID for this user
$user_id = $_SESSION['user_id'];
$res = $conn->query("SELECT Student_ID FROM student WHERE user_id='$user_id'");
$row = $res->fetch_assoc();
$student_id = $row['Student_ID'];

// Query: All approved lab schedules not booked by this student
$sql = "
SELECT 
    ls.Schedule_ID, ls.Date, ls.Start_Time, ls.End_Time, ls.Remaining_Capacity,
    l.Name AS LabName, l.Type, l.Capacity AS LabCapacity, l.Lab_ID
FROM lab_schedule ls
JOIN lab l ON ls.Lab_ID = l.Lab_ID
WHERE ls.Status = 'approved'
  AND ls.Remaining_Capacity > 0
  AND ls.Schedule_ID NOT IN (
      SELECT Schedule_ID FROM lab_booking WHERE Student_ID = '$student_id'
  )
ORDER BY ls.Date, ls.Start_Time
";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr>
            <th>Lab Name</th>
            <th>Type</th>
            <th>Lab Capacity</th>
            <th>Session Date</th>
            <th>Time</th>
            <th>Available Seats</th>
            <th>Equipment</th>
          </tr>";
    while ($row = $result->fetch_assoc()) {
        // Fetch equipment for this lab
        $lab_id = $row['Lab_ID'];
        $eq_res = $conn->query("SELECT Name, Quantity FROM lab_equipment WHERE Lab_ID=$lab_id");
        $equipment = [];
        while ($eq = $eq_res->fetch_assoc()) {
            $equipment[] = htmlspecialchars($eq['Name']) . " (Qty: {$eq['Quantity']})";
        }
        echo "<tr>
                <td>" . htmlspecialchars($row['LabName']) . "</td>
                <td>" . htmlspecialchars($row['Type']) . "</td>
                <td>" . htmlspecialchars($row['LabCapacity']) . "</td>
                <td>" . htmlspecialchars($row['Date']) . "</td>
                <td>" . htmlspecialchars($row['Start_Time']) . " - " . htmlspecialchars($row['End_Time']) . "</td>
                <td>" . htmlspecialchars($row['Remaining_Capacity']) . "</td>
                <td>" . implode(', ', $equipment) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No available labs at the moment.</p>";
}

echo "</body></html>";
?>
