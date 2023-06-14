<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");
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