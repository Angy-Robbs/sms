<?php
session_start();
include_once 'connection.php';

if (isset($_POST['removeBrandBtn'])) {
    $brand_id = $_POST['brand_id'];

    // Prepare the SQL statement to prevent SQL injection
    $sql = "UPDATE brands SET brand_status = 0 WHERE brand_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $brand_id);
    $result = $stmt->execute();

    if($result) {
        $_SESSION['status'] = "Brand removed successfully";
        header("Location: brand.php");
        exit();
    } else {
        $_SESSION['status'] = "Failed to remove brand";
        header("Location: brand.php");
        exit();
    }
}
?>
