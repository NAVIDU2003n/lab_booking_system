<?php
include 'config.php';

// Ensure only instructors can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'instructor') {
    header("Location: login.php");
    exit();
}

include 'header.php';

echo '<div class="top-right"><a href="logout.php">Logout</a></div>';
echo "<h2>Instructor Dashboard</h2>";

// Get Instructor_ID for the logged-in user
$user_id = $_SESSION['user_id'];
$instructor_res = $conn->query("SELECT Instructor_ID FROM instructor WHERE user_id='$user_id'");
$instructor_row = $instructor_res->fetch_assoc();
$instructor_id = $instructor_row['Instructor_ID'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['schedule_lab'])) {
    $lab_id = (int)$_POST['lab_id'];
    $date = $conn->real_escape_string($_POST['date']);
    $start_time = $conn->real_escape_string($_POST['start_time']);
    $end_time = $conn->real_escape_string($_POST['end_time']);
    $capacity = (int)$_POST['capacity'];

    // Find Lab_TO_ID for the selected lab
    $lab_to_res = $conn->query("SELECT Lab_TO_ID FROM lab WHERE Lab_ID=$lab_id");
    $lab_to_row = $lab_to_res->fetch_assoc();
    $lab_to_id = $lab_to_row['Lab_TO_ID'];

    // Insert into lab_schedule
    $sql = "INSERT INTO lab_schedule (Date, Start_Time, End_Time, Lab_ID, Remaining_Capacity, Status, Instructor_ID, Lab_TO_ID)
            VALUES ('$date', '$start_time', '$end_time', $lab_id, $capacity, 'pending', $instructor_id, $lab_to_id)";
    if ($conn->query($sql)) {
        echo "<p style='color:green;'>Lab scheduled successfully and is pending approval by Lab TO.</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}

// Get list of labs for dropdown
$labs_res = $conn->query("SELECT Lab_ID, Name, Capacity FROM lab");
?>

<h3>Schedule a New Lab Session</h3>
<form method="post" action="">
    <label>Lab:</label>
    <select name="lab_id" required>
        <option value="">Select Lab</option>
        <?php while ($lab = $labs_res->fetch_assoc()): ?>
            <option value="<?= $lab['Lab_ID'] ?>">
                <?= htmlspecialchars($lab['Name']) ?> (Capacity: <?= $lab['Capacity'] ?>)
            </option>
        <?php endwhile; ?>
    </select><br><br>
    <label>Date:</label>
    <input type="date" name="date" required><br><br>
    <label>Start Time:</label>
    <input type="time" name="start_time" required><br><br>
    <label>End Time:</label>
    <input type="time" name="end_time" required><br><br>
    <label>Initial Capacity:</label>
    <input type="number" name="capacity" min="1" required><br><br>
    <button type="submit" name="schedule_lab">Schedule Lab</button>
</form>

<hr>

<h3>Your Scheduled Labs</h3>
<?php
// Show all schedules created by this instructor
$schedules = $conn->query("SELECT ls.*, l.Name as LabName FROM lab_schedule ls
    JOIN lab l ON ls.Lab_ID = l.Lab_ID
    WHERE ls.Instructor_ID = $instructor_id
    ORDER BY ls.Date DESC, ls.Start_Time DESC");
if ($schedules->num_rows > 0) {
    echo "<table border='1' cellpadding='5'><tr>
        <th>Lab</th><th>Date</th><th>Time</th><th>Capacity</th><th>Status</th></tr>";
    while ($row = $schedules->fetch_assoc()) {
        echo "<tr>
            <td>" . htmlspecialchars($row['LabName']) . "</td>
            <td>" . $row['Date'] . "</td>
            <td>" . $row['Start_Time'] . " - " . $row['End_Time'] . "</td>
            <td>" . $row['Remaining_Capacity'] . "</td>
            <td>" . ucfirst($row['Status']) . "</td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No scheduled labs yet.</p>";
}

echo "</body></html>";
?>



