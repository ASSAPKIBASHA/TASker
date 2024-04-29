<!-- register.php -->
<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
        exit();
    } else {
        //$error_message = "Error: " . $sql . "<br>" . $conn->error;
        echo'Email taken';

    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>TASKer</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        form {
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background:#333;
        }
        
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        
        button[type="submit"] {
            width: 100%;
            background-color: gray;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        button[type="submit"]:hover {
            background-color: #24092e;
        }
        a:hover{
            color:#24292e;
            font-size:1.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 style="margin-left:530px;font-family:robotto;color:#24292e;">REGISTER</h1>

        <?php if (isset($error_message)) echo "<p class='error-message'>$error_message</p>"; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <p style="margin-left: 510px; font-size: 14px; font-weight: bold;">Already have an account? <a href="login.php"  style="color: blue; text-decoration: underline;text-decoration: none;color:gray;transition:2s ease-in-out;">Login</a></p>

    </div>
</body>
</html>
