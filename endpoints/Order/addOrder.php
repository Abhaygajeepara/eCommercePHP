<?php
require_once('../includes/config.php');
require_once('../includes/keyword.php');
$response = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $order_date = date('Y-m-d');
    $total_amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : '';
    $items = isset($_POST['items']) ? $_POST['items'] : '';
    // $shipping_address = isset($_POST['shipping_address']) ? $_POST['shipping_address'] : '';

    if(!empty($user_id)  && !empty($total_amount) && !empty($items) ){
        if(is_numeric($user_id)){

            // get address
            $addressQuery = "SELECT shipping_address from user where id = '$user_id'";
            $addressResult = $conn->query($addressQuery);
            $row = mysqli_fetch_assoc($addressResult);
            $shipping_address = $row['shipping_address'];

            $query = "INSERT INTO `order` (user_id, order_date, total_amount, items, shipping_address) VALUES ('$user_id', '$order_date', '$total_amount', '$items', '$shipping_address')";
            if($conn->query($query)){
                $mainResponse[$status_keyword] = true;
    $mainResponse[$message_keyword] = $order_successful_keyword;
            }else{
                $mainResponse[$status_keyword] = false;
    $mainResponse[$message_keyword] = $order_failed_keyword;
            }
        }else{
    $mainResponse[$status_keyword] = false;
    $mainResponse[$message_keyword] = $int_validation_keyword;
        }
    }
    else{
    $mainResponse[$status_keyword] = false;
    $mainResponse[$message_keyword] = $missing_parameter_keyword;
    }



}else{
    $mainResponse[$status_keyword] = false;
    $mainResponse[$message_keyword] = $wrongRequest_message_keyword;
}

header("CONTENT-TYPE:JSON");
echo json_encode($mainResponse, JSON_PRETTY_PRINT);
