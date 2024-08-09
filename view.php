<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Table Styles */
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #007bff; /* Blue color for table header */
            color: white;
        }

        /* Button Styles */
        .assignment-button {
            background-color: #007bff; /* Blue color for button */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            padding: 8px 16px; /* Adjust padding for better button size */
        }

        .assignment-button:hover {
            background-color: #0056b3; /* Darker shade of blue for hover state */
        }

        /* Responsive Design */
        @media only screen and (max-width: 768px) {
            table {
                font-size: 14px;
            }
            .assignment-button {
                font-size: 10px;
                padding: 6px 12px;
            }
        }
    </style>

</head>
<body>

<table>
    <tr>
        <th>Assignment</th>
        <th>Timer</th>
        <th>Actions</th>
    </tr>
<?php
session_start();

// Establishing a connection to the database (replace these values with your database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$teacher_name = $_SESSION['teacher_name'] ?? '';

// Fetching assignments from the database
$sql = "SELECT id, title, timer FROM exam WHERE teacher = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $teacher_name);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error executing query: " . $conn->error);
}

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td><button class='assignment-button' onclick='viewAssignment(\"" . $row["title"] . "\")'>" . $row["title"] . "</button></td>
                <td>" . $row["timer"] . " mins</td>
                <td>
                    
                    <button class='assignment-button' onclick='deleteAssignment(\"" . $row["id"] . "\")'>Delete</button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='3'>No assignments found</td></tr>";
}

$stmt->close();
$conn->close();
?>

<script>
    function viewAssignment(title) {
        window.location = "view2.php?title=" + title;
    }

    function editAssignment(id, title, timer) {
        // Add your edit functionality here
        alert("Edit assignment with ID: " + id + ", Title: " + title + ", Timer: " + timer);
    }

    function deleteAssignment(id) {
        if (confirm("Are you sure you want to delete this assignment?")) {
            window.location = "delete_assignment.php?id=" + id;
        }
    }
</script>
</table>

</body>
</html>