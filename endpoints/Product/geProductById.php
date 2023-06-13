<?php
require_once('../includes/config.php');
require_once('../includes/keyword.php');
$response = array();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $product_id =isset($_GET['product_id']) ? $_GET['product_id'] : '';
    if(!empty($product_id) && is_numeric($product_id)){
       $query = "SELECT * FROM `product` where id = '$product_id'"; 
        $result = $conn->query($query);
        if (mysqli_num_rows($result)>0) {
            $row = mysqli_fetch_assoc($result);
            $response['id'] = $row['id'];
                    $response['description'] = $row['description'];
                    $response['image'] = $row['image'];
                    $response['pricing'] = $row['pricing'];
                    $response['shippingcost'] = $row['shippingcost'];
                    $commentquery = "SELECT * FROM `comments` where product_id = '$product_id'"; 
                    $commentResult = $conn->query($commentquery);
                    $commentResponse = array();
                    if ($commentResult->num_rows > 0) {
                        $i = 0;
                        while($commentRow = mysqli_fetch_assoc($commentResult)) {
                            $commentResponse[$i]['id'] = $commentRow['id'];
                            $commentResponse[$i]['product_id'] = $commentRow['product_id'];
                            $commentResponse[$i]['user_id'] = $commentRow['user_id'];
                            $commentResponse[$i]['rating'] = $commentRow['rating'];
                            // $response[$i]['image'] = $row['image'];
                            $commentResponse[$i]['comment_text'] = $commentRow['comment_text'];
                            $list = explode(',', $commentRow['image']);
                            foreach($list as $img){
                                $commentResponse[$i]['image'][] = $getImagePath .$img;
                            }
                            $i++;
                        }
                        $response['comments'] = $commentResponse;
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
?>