<?php
session_start();
include_once 'connection.php';

if (isset($_POST['removeBrandBtn'])) {
    // Check if brand_id is set and not empty
    if (!isset($_POST['brand_id']) || empty($_POST['brand_id'])) {
        $_SESSION['status'] = "Brand ID is missing.";
        header("Location: brand.php");
        exit();
    }

    // Get the brand_id from the POST request
    $brand_id = $_POST['brand_id'];

    try {
        // Prepare the SQL statement to update the brand status
        $sql = "UPDATE brands SET brand_status = 0 WHERE brand_id = :brand_id";
        $stmt = $conn->prepare($sql);

        // Bind the brand_id parameter to the SQL query
        $stmt->bindParam(':brand_id', $brand_id, PDO::PARAM_INT);

        // Execute the statement and check if it was successful
        if ($stmt->execute()) {
            $_SESSION['status'] = "Brand removed successfully";
        } else {
            $_SESSION['status'] = "Failed to remove brand";
        }

        // Redirect to the brand page
        header("Location: brand.php");
        exit();

    } catch (PDOException $e) {
        // Handle any errors
        $_SESSION['status'] = "Database error: " . $e->getMessage();
        header("Location: brand.php");
        exit();
    }
}
?>
