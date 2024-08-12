<?php
session_start();
include 'connection.php';

// Update brand in the database
if(isset($_POST['editBrandBtn'])){
    $brand_name = $_POST['edit_brand_name'];
    $brand_status = $_POST['edit_brand_status'];
    $id = $_POST['brand_id'];

    // Perform the update
    $sql = "UPDATE brands SET brand_name='$brand_name', brand_status='$brand_status' WHERE brand_id='$id'";
    if (mysqli_query($conn, $sql)) {
        // Redirect to the same page or a success page
        header("Location: editBrand.php?brand_id=$id&success=1");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

// Display brand details based on the selected brand_id
if (isset($_GET['brand_id']) && !empty($_GET['brand_id'])) {
    $brand_id = $_GET['brand_id'];
    $result = mysqli_query($conn, "SELECT * FROM brands WHERE brand_id=$brand_id");

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        response($row['brand_id'], $row['brand_name'], $row['brand_status']);
    } else {
        response(NULL, NULL, NULL, "No Record Found");
    }
}

// Function to send a JSON response
function response($brand_id, $brand_name, $brand_status, $message = '') {
    $response = [
        'brand_id' => $brand_id,
        'brand_name' => $brand_name,
        'brand_status' => $brand_status,
        'message' => $message
    ];
    echo json_encode($response);
}
?>
