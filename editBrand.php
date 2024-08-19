<?php
include "connection.php";

$id = "";
$brand_name = "";
$brand_status = "";
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (!isset($_POST['brand_id'])) {
        $error = "Invalid Request";
        header("Location: brand.php?error=" . urlencode($error));
        exit;
    }

    $id = $_POST['brand_id'];
    $brand_name = $_POST["edit_brand_name"];
    $brand_status = $_POST["edit_brand_status"];

    $sql = "UPDATE brands SET brand_name=?, brand_status=? WHERE brand_id=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }

    $stmt->bind_param("ssi", $brand_name, $brand_status, $id);

    if ($stmt->execute()) {
        $success = "Brand updated successfully!";
        header("Location: editBrand.php?brand_id=$id&success=" . urlencode($success));
    } else {
        $error = "Error updating brand: " . $stmt->error;
        header("Location: editBrand.php?brand_id=$id&error=" . urlencode($error));
    }

    $stmt->close();
}

$conn->close();
?>
