<?php
session_start();
include 'connection.php';

// Check if the database connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Update brand in the database
if(isset($_POST['editBrandBtn'])){
    // Validate and sanitize inputs
    $brand_name = mysqli_real_escape_string($conn, $_POST['edit_brand_name']);
    $brand_status = mysqli_real_escape_string($conn, $_POST['edit_brand_status']);
    $id = intval($_POST['brand_id']); // Ensure the ID is an integer

    // Perform the update using a prepared statement
    $stmt = $conn->prepare("UPDATE brands SET brand_name=?, brand_status=? WHERE brand_id=?");
    $stmt->bind_param("sii", $brand_name, $brand_status, $id);

    if ($stmt->execute()) {
        // Redirect to the same page or a success page
        header("Location: editBrand.php?brand_id=$id&success=1");
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close(); // Close the prepared statement
}

// Display brand details based on the selected brand_id
if (isset($_GET['brand_id']) && !empty($_GET['brand_id'])) {
    $brand_id = intval($_GET['brand_id']); // Ensure the ID is an integer
    $stmt = $conn->prepare("SELECT * FROM brands WHERE brand_id=?");
    $stmt->bind_param("i", $brand_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        response($row['brand_id'], $row['brand_name'], $row['brand_status']);
    } else {
        response(NULL, NULL, NULL, "No Record Found");
    }

    $stmt->close(); // Close the prepared statement
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
