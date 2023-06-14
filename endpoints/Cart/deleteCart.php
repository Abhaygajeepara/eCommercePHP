<?php
require_once('../includes/config.php');
require_once('../includes/keyword.php');
$response = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = isset($_POST['productId']) ? $_POST['productId'] : '';
    // $quantities = isset($_POST['quantities']) ? $_POST['quantities'] : '';
    $userId = isset($_POST['userId']) ? $_POST['userId'] : '';
   if(!empty($productId)  && !empty($userId)){
    try{
        
        if(!is_numeric($productId)  || !is_numeric($userId))  
        {
            $mainResponse[$status_keyword] = false;
            $mainResponse[$message_keyword] = $int_validation_keyword;  
        }else{
        $existQuery = "SELECT * FROM cart WHERE user_id = $userId AND product_id = $productId";
        $existResult = $conn->query($existQuery);

        if(mysqli_num_rows($existResult) > 0){
            $deletequery = "DELETE FROM cart WHERE user_id = $userId AND product_id = $productId";
           if($conn->query($deletequery)){
            $mainResponse[$status_keyword] = true;
            $mainResponse[$message_keyword] = $successfulMessage_keyword;
           }
           else{
            $mainResponse[$status_keyword] = false;
            $mainResponse[$message_keyword] = $fail_keyword ;
           }
           
           
           
        }else{
            $mainResponse[$status_keyword] = false;
            $mainResponse[$message_keyword] = $dataNotfound_message_keyword ;
        }
       
}
    }
    catch(Exception $e){
        $mainResponse[$status_keyword] = false;
        $mainResponse[$message_keyword] = $internal_message_keyword;
    }
   }else{
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
