<?php
try{
   $localhost = "localhost";
$username = "root";
$password = "";
$database = "ecommerce";
 $conn =    mysqli_connect($localhost,$username,$password,$database);
$mainResponse = array(); 
 if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
 }
}
catch(Exception $e){
   echo "Connetion failed";
}


?>