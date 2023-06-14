<?php
//Include the required files
require_once('../includes/config.php');
require_once('../includes/keyword.php');

//create an array to store responses
$response = array();

//check the request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //retrieve the email and password from the POST data 
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

//check both email and password are not empty
if(!empty($email) && !empty($password)){
    try {
        //build the query to fetch the user data 
        $query = "SELECT * FROM user WHERE email = '{$email}' AND password = '{$password}'";

        //execute the query
        $result =  $conn->query($query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            // while ($row = mysqli_fetch_assoc($result))

            //check whether email and password matches with the retrieved data
            if($row['email'] == $email && $password == $row['password'])
            {
                $response['id'] = $row['id'];
                $response['email'] = $row['email'];
                $response['username'] = $row['username'];
                $mainResponse[$data_keyword] = $response;
                $mainResponse[$status_keyword] = true;
            }else{
                $mainResponse[$data_keyword] = $response;
                $mainResponse[$status_keyword] = true;
                $mainResponse[$message_keyword] = $wrong_credential_keyword;
        
            }
           
        }
    }
    //display error messages 
    catch (Exception $e) {
        $mainResponse[$status_keyword] = false;
        $mainResponse[$message_keyword] = $internal_message_keyword;
    }
}
else{
    $mainResponse[$data_keyword] = $response;
    $mainResponse[$status_keyword] = false;
    $mainResponse[$message_keyword] = $missing_parameter_keyword;

}

}
else{
    $mainResponse[$data_keyword] = $response;
    $mainResponse[$status_keyword] = false;
    $mainResponse[$message_keyword] = $wrongRequest_message_keyword;
}

//set the header content type as JSON
header("CONTENT-TYPE:JSON");

//encode the main response array as JSON
echo json_encode($mainResponse, JSON_PRETTY_PRINT);
?>

