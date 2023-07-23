<?php

//include required files
require_once('../includes/config.php');
require_once('../includes/keyword.php');
$response = array();
if ($_SERVER['REQUEST_METHOD'] === 'GET'){
   
    $userId =  isset($_GET['userId']) ? $_GET['userId'] : '';
    if(!empty($userId) && is_numeric($userId)){
try {
    $query = "select * from user where id = $userId";
    
    $result =  $conn->query($query);
    if ($result) {
        if (mysqli_num_rows($result)>0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $response['id'] = $row['id'];
                $response['email'] = $row['email'];
                $response['username'] = $row['username'];
                $response['shipping_address'] = $row['shipping_address'];
            }
            $mainResponse[$data_keyword] = $response;
            $mainResponse[$status_keyword] = true;
            $mainResponse[$message_keyword] = $successfulMessage_keyword;
        }else{
         
            $mainResponse[$status_keyword] = false;
            $mainResponse[$message_keyword] = $dataNotfound_message_keyword;
        }
       
    }
} catch (Exception $e) {
    $mainResponse['status'] = false;
}
    }else{
        $mainResponse[$status_keyword] = false;
        $mainResponse[$message_keyword] = $missing_parameter_keyword . " OR " . $int_validation_keyword; 
    }
}
else{
    $mainResponse[$status_keyword] = false;
    $mainResponse[$message_keyword] = $wrongRequest_message_keyword; 
}

header("CONTENT-TYPE:JSON");

//encode the response array as JSON and display
echo json_encode($mainResponse, JSON_PRETTY_PRINT);

?>
