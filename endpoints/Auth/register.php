<?php
require_once('../includes/config.php');
require_once('../includes/keyboard.php');
$response = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $shippingAddress = isset($_POST['shipping_address']) ? $_POST['shipping_address'] : '';;    

if(!empty($email) && !empty($password) && !empty($username) && !empty($shippingAddress)){
    try {
        $existQuery = "SELECT * FROM user WHERE email = '$email'";
        $existResult = $conn->query($existQuery);

        if(mysqli_num_rows($existResult) > 0){
            $mainResponse[$status_keyword] = false;
            $mainResponse[$message_keyword] = $userExist_message_keyword;
        }
        else{
        $query = "INSERT INTO user (email, `password`, username, shipping_address) VALUES ('$email', '$password', '$username', '$shippingAddress')";
        if($conn->query($query)){
            $mainResponse[$status_keyword] = true;
    $mainResponse[$message_keyword] = $registeration_successful_keyword;
        }
        else{
            $mainResponse[$status_keyword] = false;
            $mainResponse[$message_keyword] = $registeration_fail_keyword;
        }
    }
    } catch (Exception $e) {
        $mainResponse[$status_keyword] = false;
        $mainResponse[$message_keyword] = $internal_message_keyword;
    }
}
else{
  
    $mainResponse[$status_keyword] = false;
    $mainResponse[$message_keyword] = $missing_parameter_keyword;

}

}
else{
    
    $mainResponse[$status_keyword] = false;
    $mainResponse[$message_keyword] = $wrongRequest_message_keyword;
}
header("CONTENT-TYPE:JSON");
echo json_encode($mainResponse, JSON_PRETTY_PRINT);


?>
