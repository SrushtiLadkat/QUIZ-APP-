<?php
  $username = $_POST['username'];
  $age = $_POST['age'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Database connection
  $conn = new mysqli('localhost', 'root', '', 'test');
  if ($conn->connect_error) {
    echo "$conn->connect_error";
    die("Connection Failed : " . $conn->connect_error);
  } else {
    // Check if user already exists
    $check_stmt = $conn->prepare("SELECT * FROM history WHERE username = ? OR email = ?");
    $check_stmt->bind_param("ss", $username, $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    if ($result->num_rows > 0) {
      echo "User with this username or email already exists.";
    } else {
      // Insert user data
      $stmt = $conn->prepare("INSERT INTO history (username, age, phone, email, password) VALUES (?, ?, ?, ?, ?)");
      // Hash the password
      //$hashed_password = password_hash($password, PASSWORD_DEFAULT);
      $stmt->bind_param("sisss", $username, $age, $phone, $email, $password);
      $stmt->execute();
      echo "Registration successful.";
      // Redirect to detail.html
      echo "<script>window.location.href = 'historylogin.php';</script>";
      // Add JavaScript to prevent going back to the previous page
      echo "<script>
          window.onbeforeunload = function() {
            return 'Form submission declined. Please register again.';
          };
         </script>";
    }
    $check_stmt->close();
    $conn->close();
  }
?>