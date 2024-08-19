<?php
    include "connection.php";
    if(isset($_GET['brand_id'])){
        $id = $_GET['brand_id'];
        $sql = "DELETE from `brands` where brand_id=$id";
        $conn->query($sql);
    }
    header('location:brand.php');
    exit;
?>
