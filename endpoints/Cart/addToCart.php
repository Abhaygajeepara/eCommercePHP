<?php
require_once('../includes/config.php');
require_once('../includes/keyword.php');
$response = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producId = isset($_POST['productId']) ? $_POST['productId'] : '';
    $quantities = isset($_POST['quantities']) ? $_POST['quantities'] : '';
    $userId = isset($_POST['userId']) ? $_POST['userId'] : '';
   if(!empty($producId) && !empty($quantities) && !empty($userId)){
    try{
    
        
        // check the paras are empty
        if(!is_numeric($producId) || !is_numeric($quantities) || !is_numeric($userId))  
        {
            $mainResponse[$status_keyword] = false;
            $mainResponse[$message_keyword] = $int_validation_keyword;  
        }else{
        $existQuery = "SELECT * FROM cart WHERE user_id = $userId AND product_id = $producId";
        $existResult = $conn->query($existQuery);

        if(mysqli_num_rows($existResult) > 0){
            $Updatequery = "UPDATE cart SET quantity = $quantities WHERE user_id = $userId AND product_id = $producId";
           if($conn->query($Updatequery)){
            $mainResponse[$status_keyword] = true;
            $mainResponse[$message_keyword] = $quantityUpdate_message_keyword;
           }
           else{
            $mainResponse[$status_keyword] = false;
            $mainResponse[$message_keyword] = $quantityUpdateFailed_message_keyword ;
           }
           
           
           
        }
        else{
        $query = "INSERT INTO cart (product_id, quantity, user_id) VALUES ('$producId', '$quantities', '$userId')";
        if($conn->query($query)){
            $mainResponse[$status_keyword] = true;
    $mainResponse[$message_keyword] = $addToCartSuccessfully_message_keyword;
        }
        else{
            $mainResponse[$status_keyword] = false;
            $mainResponse[$message_keyword] = $addToCartFailed_message_keyword;
        }
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
