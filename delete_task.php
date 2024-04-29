<!-- delete_task.php -->
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

// Get the task ID
$task_id = $_GET['id'];

// Delete the task from the database
$sql = "DELETE FROM tasks WHERE id = $task_id";

if ($conn->query($sql) === TRUE) {
    // Do nothing, the JavaScript will remove the task from the UI
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>