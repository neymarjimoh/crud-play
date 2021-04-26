<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'maffmann');
define('DB_NAME', 'crud-play');
 
/* Attempt to connect to MySQL database */
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
 
// Check connection
if(!$conn){
    die("ERROR: Database connection failed. " . mysqli_connect_error());
}
?>
