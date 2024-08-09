<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments</title>
    <style>
        /* Global styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        /* Table styles */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #007bff; /* Blue */
            color: #fff;
            font-weight: bold;
        }

        /* Button styles */
        .assignment-button {
            background-color: #007bff; /* Blue */
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            padding: 10px 20px;
        }

        .assignment-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        /* Heading styles */
        h2 {
            color: #007bff; /* Blue */
            margin-top: 0;
        }
    </style>
</head>
<body>

<?php
session_start(); // Add this line

// Establishing a connection to the database (replace these values with your database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

// Fetch assignments from the database
$sql = "SELECT id, title, timer, subject FROM exam";
$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: ". $conn->error);
}

$assignments = [];
if ($result->num_rows > 0) {
    // Group assignments by subject
    while ($row = $result->fetch_assoc()) {
        $assignments[$row["subject"]][] = $row;
    }
} else {
    echo "<p>No assignments found</p>";
}

// Display assignments grouped by subject
foreach ($assignments as $subject => $subjectAssignments) {
    echo "<h2>$subject</h2>";
    echo "<table>";
    echo "<tr><th>Assignment</th><th>Timer</th><th>Status</th></tr>"; // Add a new column for status
    foreach ($subjectAssignments as $assignment) {
        // Check if the assignment has been submitted by the student
        $sql = "SELECT status FROM marks WHERE title =? AND stu_name =?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $assignment["title"], $_SESSION['student_name']);
        $stmt->execute();
        $result = $stmt->get_result();
        $submitted = $result->num_rows > 0 && $result->fetch_assoc()["status"] == "completed";

        if (!$submitted) {
            echo "<tr><td><button class='assignment-button' onclick='viewAssignment(\"". $assignment["title"]. "\")'>". $assignment["title"]. "</button></td><td>". $assignment["timer"]. " mins</td><td>Pending</td></tr>";
        } else {
            echo "<tr><td>". $assignment["title"]. "</td><td>". $assignment["timer"]. " mins</td><td>Completed</td></tr>";
        }
        $stmt->close();
    }
    echo "</table>";
}

$conn->close(); // Close the connection after you're done with it
?>

<script>
    function viewAssignment(title) {
    window.location = "assignments.php?title=" + title;
	}
</script>

</body>
</html>