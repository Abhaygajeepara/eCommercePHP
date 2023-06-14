<?php
//Includes required files
require_once('../includes/config.php');
require_once('../includes/keyword.php');
$response = array();

//checking whether the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Retrieve the email password username and shipping address from the POST data 
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $shippingAddress = isset($_POST['shipping_address']) ? $_POST['shipping_address'] : '';;    

//check if all the required fields are not empty
if(!empty($email) && !empty($password) && !empty($username) && !empty($shippingAddress)){
    try {

        //to check if user already exists in the database
        $existQuery = "SELECT * FROM user WHERE email = '$email'";
        $existResult = $conn->query($existQuery);

        if(mysqli_num_rows($existResult) > 0){
            //set the response and display error message
            $mainResponse[$status_keyword] = false;
            $mainResponse[$message_keyword] = $userExist_message_keyword;
        }
        else{
        
        //user doesnt exists then add the user and completes the registration. Build the query for inserting a new user
        $query = "INSERT INTO user (email, `password`, username, shipping_address) VALUES ('$email', '$password', '$username', '$shippingAddress')";
        if($conn->query($query)){
            //Registration succesful
            $mainResponse[$status_keyword] = true;
            $mainResponse[$message_keyword] = $successfulMessage_keyword;
            
        }
        else{
            //Registration Failed
            $mainResponse[$status_keyword] = false;
            $mainResponse[$message_keyword] = $registeration_fail_keyword;
        }
    }
    } catch (Exception $e) {
        //If there is an internal error 
        $mainResponse[$status_keyword] = false;
        $mainResponse[$message_keyword] = $internal_message_keyword;
    }
}
else{
    //If any params are missing then display this message
    $mainResponse[$status_keyword] = false;
    $mainResponse[$message_keyword] = $missing_parameter_keyword;

}

}
else{
    //If any wrong request is passed then display this message
    $mainResponse[$status_keyword] = false;
    $mainResponse[$message_keyword] = $wrongRequest_message_keyword;
}
//set the header content type as JSON
header("CONTENT-TYPE:JSON");

//encode the response array as JSON and display
echo json_encode($mainResponse, JSON_PRETTY_PRINT);


?>
