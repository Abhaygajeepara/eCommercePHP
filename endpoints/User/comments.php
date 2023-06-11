<?php
require_once('../includes/config.php');
require_once('../includes/keyboard.php');
$userId = $_GET['userId'];


$response = array();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = isset($_POST['userId']) ? $_POST['userId'] : '';
    $commentText = isset($_POST['commentText']) ? $_POST['commentText'] : '';

   
    if(!empty($userId) && is_numeric($userId)){
        $query = "SELECT * FROM `comments` WHERE `id` = '$userId'";

        if (!empty($userId) && !empty($commentText)) {
            // Check if an image is uploaded
            if (!empty($_FILES['image']['name'])) {
                $imagePath = 'path/to/save/' . $_FILES['image']['name'];
    
                // Move the uploaded image to the desired location
                if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                    // Store the comment and image path in the database
                    $query = "INSERT INTO `comments` (`id`, `comment_text`, `image_path`) 
                              VALUES ('$userId', '$commentText', '$imagePath')";
                   
                $result = $conn->query($query);


                if($result){

                  if(mysqli_num_rows($result)>0){
                    $i = 0;
                    while($row = mysqli_fetch_assoc($result)){
                        $response[$i]['id'] = $row['userId'];
                        $response[$i]['productId'] = $row['productId'];
                        $response[$i]['rating'] = $row['rating'];
                        $response[$i]['image'] = $row['image'];
                        $response[$i]['text'] = $row['text'];
                        $i++;
                    }
                    $mainResponse[$status_keyword] = true;
                    $mainResponse[$data_keyword] = $response;
                    $mainResponse[$message_keyword] = $dataFound_message_keyword;
                }
                else
                {
                $mainResponse[$status_keyword] = false;
                $mainResponse[$message_keyword] = $dataNotfound_message_keyword;
                }
              }
            }

        }
    }
 }
 header("CONTENT-TYPE:JSON");
echo json_encode($mainResponse, JSON_PRETTY_PRINT);

}

?>
