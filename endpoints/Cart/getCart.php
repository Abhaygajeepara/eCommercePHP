<?php
//include required files
require_once('../includes/config.php');
require_once('../includes/keyword.php');
$response = array();

//check whether request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET'){

    $userId = isset($_GET['userId']) ? $_GET['userId'] : '';

    //check whether userid is not empty and is numeric
    if(!empty($userId) && is_numeric($userId)){
        $query = "SELECT * FROM `cart` WHERE `user_id` = '$userId'";
        $result = $conn->query($query);
        if($result){

            if(mysqli_num_rows($result)>0){
            $i = 0;
                    while($row = mysqli_fetch_assoc($result)){
                        $response[$i]['productId'] = $row['product_id'];
                        $productId =  $response[$i]['productId'];
                        $productQuery = "SELECT * FROM `product` WHERE `id` = '$productId'";
                        $productresult = $conn->query($productQuery);
                        
                           if(mysqli_num_rows($productresult)>0){
                            $Productrow = mysqli_fetch_assoc($productresult);
                            
                            $response[$i]['description'] = $Productrow['description'];
                            $response[$i]['image'] = $Productrow['image'];
                            $response[$i]['pricing'] = $Productrow['pricing'];
                            
                        }
                        $response[$i]['quantities'] = $row['quantity'];
                        $response[$i]['userId'] = $row['user_id'];
                        $i++;
                    }
                    $mainResponse[$status_keyword] = true;
                    $mainResponse[$data_keyword] = $response;
            $mainResponse[$message_keyword] = $dataFound_message_keyword;
                }else{
                $mainResponse[$status_keyword] = false;
                $mainResponse[$message_keyword] = $dataNotfound_message_keyword;
            }
        
        }
        
    }
    else{
        $mainResponse[$status_keyword] = false;
        $mainResponse[$message_keyword] = $missing_parameter_keyword . " OR " . $int_validation_keyword; 
    }
}
else{
    $mainResponse[$status_keyword] = false;
    $mainResponse[$message_keyword] = $wrongRequest_message_keyword;
}
header("CONTENT-TYPE:JSON");
echo json_encode($mainResponse, JSON_PRETTY_PRINT);
