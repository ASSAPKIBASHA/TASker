<!-- update_task.php -->
<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "tasker";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request is to update the status or the entire task
if (isset($_GET['id']) && isset($_GET['status'])) {
    $task_id = $_GET['id'];
    $status = $_GET['status'];

    // Update the task status
    $sql = "UPDATE tasks SET status = '$status' WHERE id = $task_id";

    if ($conn->query($sql) === TRUE) {
        // Do nothing, the JavaScript will update the UI
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];

    // Update the entire task
    $sql = "UPDATE tasks SET title = '$title', description = '$description', due_date = '$due_date', status = '$status' WHERE id = $task_id";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='task' data-id='$task_id'>";
        echo "<h3>$title</h3>";
        echo "<p>Description: $description</p>";
        echo "<p>Due Date: $due_date</p>";
        echo "<p>Status: $status</p>";
        echo "<button class='complete-btn'>Mark as Complete</button>";
        echo "<button class='edit-btn'>Edit</button>";
        echo "<button class='delete-btn'>Delete</button>";
        echo "</div>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>