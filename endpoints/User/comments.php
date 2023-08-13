<?php

//Includes required files
require_once('../includes/config.php');
require_once('../includes/keyboard.php');

//Retrieve the userId
$userId = $_GET['userId'];

//create a response array
$response = array();

//checking whether the request method is POST

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Retrieve the userId and commentText 
    $userId = isset($_POST['userId']) ? $_POST['userId'] : '';
    $commentText = isset($_POST['commentText']) ? $_POST['commentText'] : '';

   //check whether userId is not empty and userId is numeric
    if(!empty($userId) && is_numeric($userId)){
        $query = "SELECT * FROM `comments` WHERE `id` = '$userId'";

        //check whether userid and commentText are not empty  
        if (!empty($userId) && !empty($commentText)) {

            // Check if an image is uploaded
            if (!empty($_FILES['image']['name'])) {
                $imagePath = 'C:/xampp/htdocs/Web/week5/uploads/' . $_FILES['image']['name'];
    
                // Move the uploaded image to the specified location
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

 //set the header content type as JSON
 header("CONTENT-TYPE:JSON");

 //Encode the main response array and display as JSON
echo json_encode($mainResponse, JSON_PRETTY_PRINT);

}

?>
