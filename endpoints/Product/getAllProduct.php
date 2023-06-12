<?php

require_once('../includes/config.php');
require_once('../includes/keyword.php');
$response = array();

    $query  = "SELECT * FROM `product`";
    $result = $conn->query($query);
    if($result){
                $i = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $response[$i]['id'] = $row['id'];
                    $response[$i]['description'] = $row['description'];
                    $response[$i]['image'] = $row['image'];
                    $response[$i]['pricing'] = $row['pricing'];
                    $response[$i]['shippingcost'] = $row['shippingcost'];
                    $i++;
                }
                $mainResponse[$data_keyword] = $response;
                $mainResponse[$status_keyword] = true;
                $mainResponse[$message_keyword] = $successfulMessage_keyword;
            }
    

header("CONTENT-TYPE:JSON");
echo json_encode($mainResponse, JSON_PRETTY_PRINT);
?>