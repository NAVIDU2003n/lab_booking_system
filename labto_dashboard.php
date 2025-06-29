<?php
// labto_dashboard.php
include 'config.php';

// Only allow Lab TO
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'labto') {
    header("Location: login.php");
    exit();
}

include 'header.php';
echo '<div class="top-right"><a href="logout.php">Logout</a></div>';
echo "<h2>Lab Technical Officer Dashboard</h2>";

// Get Lab_TO_ID for this user
$user_id = $_SESSION['user_id'];
$res = $conn->query("SELECT Lab_TO_ID FROM lab_to WHERE user_id='$user_id'");
$row = $res->fetch_assoc();
$lab_to_id = $row['Lab_TO_ID'];

// Handle approval/rejection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['schedule_id'])) {
    $schedule_id = (int)$_POST['schedule_id'];
    if (isset($_POST['approve'])) {
        $capacity = (int)$_POST['final_capacity'];
        $conn->query("UPDATE lab_schedule SET Status='approved', Remaining_Capacity=$capacity WHERE Schedule_ID=$schedule_id");
        echo "<p style='color:green;'>Schedule approved!</p>";
    } elseif (isset($_POST['reject'])) {
        $conn->query("UPDATE lab_schedule SET Status='rejected' WHERE Schedule_ID=$schedule_id");
        echo "<p style='color:red;'>Schedule rejected.</p>";
    }
}

// Show schedules for labs assigned to this Lab TO
$sql = "
SELECT ls.*, l.Name AS LabName, i.Name AS InstructorName
FROM lab_schedule ls
JOIN lab l ON ls.Lab_ID = l.Lab_ID
JOIN instructor i ON ls.Instructor_ID = i.Instructor_ID
WHERE ls.Lab_TO_ID = $lab_to_id
ORDER BY ls.Date DESC, ls.Start_Time DESC
";
$schedules = $conn->query($sql);

echo "<h3>Instructor Scheduled Labs for Your Labs</h3>";
if ($schedules->num_rows > 0) {
    echo "<table border='1' cellpadding='5'>
        <tr>
            <th>Schedule ID</th>
            <th>Lab</th>
            <th>Date</th>
            <th>Time</th>
            <th>Instructor</th>
            <th>Requested Capacity</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>";
    while ($sch = $schedules->fetch_assoc()) {
        echo "<tr>
            <td>{$sch['Schedule_ID']}</td>
            <td>" . htmlspecialchars($sch['LabName']) . "</td>
            <td>{$sch['Date']}</td>
            <td>{$sch['Start_Time']} - {$sch['End_Time']}</td>
            <td>" . htmlspecialchars($sch['InstructorName']) . "</td>
            <td>{$sch['Remaining_Capacity']}</td>
            <td>" . ucfirst($sch['Status']) . "</td>
            <td>";
        if ($sch['Status'] === 'pending') {
            echo "<form method='post' style='display:inline;'>
                    <input type='hidden' name='schedule_id' value='{$sch['Schedule_ID']}'>
                    <input type='number' name='final_capacity' value='{$sch['Remaining_Capacity']}' min='1' required>
                    <button type='submit' name='approve'>Approve</button>
                  </form>
                  <form method='post' style='display:inline; margin-left:5px;'>
                    <input type='hidden' name='schedule_id' value='{$sch['Schedule_ID']}'>
                    <button type='submit' name='reject'>Reject</button>
                  </form>";
        } else {
            echo "-";
        }
        echo "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>No schedules found for your labs.</p>";
}

// Show equipment for each lab assigned to this Lab TO
$labs = $conn->query("SELECT Lab_ID, Name FROM lab WHERE Lab_TO_ID=$lab_to_id");
echo "<h3>Lab Equipment Availability</h3>";
if ($labs->num_rows > 0) {
    while ($lab = $labs->fetch_assoc()) {
        echo "<strong>" . htmlspecialchars($lab['Name']) . ":</strong><br>";
        $lab_id = $lab['Lab_ID'];
        $equip = $conn->query("SELECT Name, Quantity FROM lab_equipment WHERE Lab_ID=$lab_id");
        if ($equip->num_rows > 0) {
            echo "<ul>";
            while ($eq = $equip->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($eq['Name']) . " (Qty: {$eq['Quantity']})</li>";
            }
            echo "</ul>";
        } else {
            echo "<em>No equipment listed for this lab.</em><br>";
        }
    }
} else {
    echo "<p>You have no labs assigned.</p>";
}

echo "</body></html>";
?>
