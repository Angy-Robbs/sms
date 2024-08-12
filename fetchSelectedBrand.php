<?php 	

require_once 'connection.php';

$brand_id = $_POST['brand_id'];

$sql = "SELECT brand_id, brand_name, brand_active, brand_status FROM brands WHERE brand_id = $brand_id";
$result = $conn->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$conn->close();

echo json_encode($row);