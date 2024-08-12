<?php

include_once('connection.php');

if($_POST) {	

	$brandName = $_POST['brandName'];
  $brandStatus = $_POST['brandStatus']; 

	$sql = "INSERT INTO brands (brand_name, brand_active, brand_status) VALUES ('$brandName', '$brandStatus', 1)";

	if($conn->query($sql)) {
        header("Location: brand.php");
	} else {
	 	echo $sql . "<br>Error while adding the members";
	}


    //$conn->close();

	//echo json_encode($valid);
 
} // /if $_POST