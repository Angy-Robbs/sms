<?php

require_once 'validate.php';

//remove all session variables
session_unset();

//destroy the session
session_destroy();

header('location: http://localhost/stock/index.php');

?>