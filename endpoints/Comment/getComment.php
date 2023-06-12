<?php
require_once('../includes/config.php');
require_once('../includes/keyword.php');
$response = array();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
     $userId = isset($_GET['product_id']) ? $_GET['product_id'] : '';
     if(!empty($userId) && is_numeric($userId)){
        $query = "SELECT * FROM `comments` where product_id = '$userId'"; 
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $i = 0;
            while($row = mysqli_fetch_assoc($result)) {
                $response[$i]['id'] = $row['id'];
                $response[$i]['product_id'] = $row['product_id'];
                $response[$i]['user_id'] = $row['user_id'];
                $response[$i]['rating'] = $row['rating'];
                // $response[$i]['image'] = $row['image'];
                $response[$i]['comment_text'] = $row['comment_text'];
                $list = explode(',', $row['image']);
                foreach($list as $img){
                    $response[$i]['image'][] = $getImagePath .$img;
                }
                $i++;
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

    }
else{
    $mainResponse[$status_keyword] = false;
    $mainResponse[$message_keyword] = $wrongRequest_message_keyword;
}
header("CONTENT-TYPE:JSON");
echo json_encode($mainResponse, JSON_PRETTY_PRINT);
