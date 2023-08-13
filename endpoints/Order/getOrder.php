<?php
require_once('../includes/config.php');
require_once('../includes/keyword.php');
$response = array();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $order_id =isset($_GET['orderId']) ? $_GET['orderId'] : '';
    if(!empty($order_id) && is_numeric($order_id)){
       $query = "SELECT * FROM `order` where id = '$order_id'"; 
        $result = $conn->query($query);
        if (mysqli_num_rows($result)>0) {
            $row = mysqli_fetch_assoc($result);
            $response['user_id'] = $row['user_id'];
            $response['order_date'] = $row['order_date'];
            $response['total_amount'] = $row['total_amount'];
            // $response['items'] = $row['items'];
            $response['shipping_address'] = $row['shipping_address'];
            $listItem = array();
            $jsonList = $row['items'];
            $list = json_decode($jsonList, true);

            
            foreach ($list as $string) {

                 $productId = $string['productId'];
                 $qty =$string['qty'];
                $singleItem = array();
               $productQuery = "SELECT * FROM `product` where id = $productId";
                $productResult = $conn->query($productQuery);
                if (mysqli_num_rows($productResult)>0) {
                   
                    $productrow = mysqli_fetch_assoc($productResult);
                     $singleItem['id'] =  $productrow['id'];
                  $singleItem['description'] = $productrow['description'];
                  $singleItem['image'] = $productrow['image'];
                  $singleItem['pricing'] = $productrow['pricing'];
                  $singleItem['shippingcost'] = $productrow['shippingcost'];
                  $singleItem['qty'] = $qty;
                }
                $response['items'][] = $singleItem;
                $listItem[] = $singleItem;

               
            }
           
            $mainResponse[$data_keyword] = $response;
            $mainResponse[$status_keyword] = true;
            $mainResponse[$message_keyword] = $dataFound_message_keyword; 
        }
        else{
        $mainResponse[$status_keyword] = false;
        $mainResponse[$message_keyword] = $dataNotfound_message_keyword; 
        }
    }else{
        $mainResponse[$status_keyword] = false;
        $mainResponse[$message_keyword] = $missing_parameter_keyword . " OR " . $int_validation_keyword; 
    }
}else{
    $mainResponse[$status_keyword] = false;
    $mainResponse[$message_keyword] = $wrongRequest_message_keyword;
}
header("CONTENT-TYPE:JSON");
echo json_encode($mainResponse, JSON_PRETTY_PRINT);
