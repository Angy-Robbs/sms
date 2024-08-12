<?php

include_once('connection.php');

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE $username = :username");
    $stmt->bindParam(':username', $username);
    //stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //if ($username && password_verify($password, $username['password'])) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "<script language='javascript'>";
    // echo "alert('Invalid username or password. Please try again.')";
    echo "</script>";
}
//}

?>
