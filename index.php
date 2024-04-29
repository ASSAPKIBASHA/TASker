<!-- index.php -->
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

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

//Fetch tasks from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM tasks WHERE user_id = $user_id ORDER BY due_date";
$result = $conn->query($sql);


$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>TASKer</title>
    <link rel="stylesheet" href="tkm.css">
    
    
</head>
<body>
    <header>
        <h1>TASKer</h1>
        <nav>
            <ul>
                <nav>
    <ul style="list-style-type: none; margin: 0; padding: 0; overflow: hidden; background-color: #333;margin-left:820px;margin-top:-40px;">
        <li style="float: right;"><a href="logout.php" style="display: block; color: white;font-weight:bolder; text-align: center; padding: 14px 16px; text-decoration: none;">Logout</a></li>
        <li style="float: right;"><a href="index.php" style="display: block; color: white;font-weight:bolder; text-align: center; padding: 14px 16px; text-decoration: none;">Home</a></li>
        
    </ul>
</nav>

            </ul>
        </nav>
    </header>
    <main>
        <div id="task-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='task' data-id='" . $row['id'] . "'>";
                    echo "<h3>" . $row['title'] . "</h3>";
                    echo "<p>Description: " . $row['description'] . "</p>";
                    echo "<p>Due Date: " . $row['due_date'] . "</p>";
                    echo "<p>Status: " . $row['status'] . "</p>";
                    echo "<button class='complete-btn'>Mark as Complete</button>";
                    echo "<button class='edit-btn'>Edit</button>";
                    echo "<button class='delete-btn'>Delete</button>";
                    echo "</div>";
                }
            } else {
                echo "No tasks found.";
            }
            ?>
        </div>
        <button id="add-task-btn">New TAsk</button>
<div id="task-form" style="display: none;">
  <h2>New Task</h2>
  
  <form id="task-form-element">
    
    <input type="text" id="title" placeholder="Title">
    
    <textarea id="description" placeholder="Description" required></textarea>
    
    <input type="date" id="due-date" required>
    
    <select id="status">
      <option value="To Do">To Do</option>
      <option value="In Progress">In Progress</option>
      <option value="Completed">Completed</option>
    </select>
    
    <button type="submit">Save</button>
    
    <button type="button" id="cancel-btn">Cancel</button>
    
  </form>
  
</div>



    </main>
    <script src="script.js"></script>
</body>
</html>
