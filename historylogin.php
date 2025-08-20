<?php
session_start(); // Start the session
$username = $_POST['username'];
$password = $_POST['password'];
// Database connection
$conn = new mysqli('localhost', 'root', '', 'test');
if ($conn->connect_error) {
    echo "$conn->connect_error";
    die("Connection Failed : " . $conn->connect_error);
} else {
    // Login functionality
    $check_stmt = $conn->prepare("SELECT * FROM history WHERE username = ? AND password = ?");
    $check_stmt->bind_param("ss", $username, $password);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
}
    if ($result->num_rows > 0) {
        // If login successful, set session variables
        $_SESSION['username'] = $username;
        echo "Logged  In Successfully! Welcome ". $username;
        header("refresh:3; url=http://localhost/AWTL1/historyquiz.html");
    } 
    else 
    {
        echo "Incorrect User name or Password! Please try again...";
        header("refresh:3; url=http://localhost/AWTL1/historylogin.html");
    }

    $check_stmt->close();
    $conn->close();
?>