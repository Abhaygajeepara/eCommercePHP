<?php
require_once('../includes/config.php');
require_once('../includes/keyword.php');
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    $productId = isset($_POST['product_id']) ? $_POST['product_id'] : '';
    $userId = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $rating = isset($_POST['rating']) ? $_POST['rating'] : '';
    $commentText = isset($_POST['comment_text']) ? $_POST['comment_text'] : '';
    $image = isset($_FILES['image']) ? $_FILES['image'] : null;

    if (empty($productId) || empty($userId) || empty($rating) || empty($commentText)) {
        $response[$status_keyword] = false;
        $response[$message_keyword] = $missing_parameter_keyword;
    } elseif (!is_numeric($productId) || !is_numeric($userId) || !is_numeric($rating)) {
        $response[$status_keyword] = false;
        $response[$message_keyword] = $int_validation_keyword;
    } elseif (!is_array($image)) {
        $response[$status_keyword] = false;
        $response[$message_keyword] = "No image uploaded.";
    } else {
        $imageNames = array();
      
      
if (!file_exists($targetDirectory)) {
  mkdir($targetDirectory, 0777, true);
}


        foreach ($_FILES['image']['tmp_name'] as $key => $tmpName) {
            $currentTimestamp = time();
            $fileName = basename($_FILES['image']['name'][$key]);
            $newFileName = $currentTimestamp . $fileName;
            $targetFilePath = $targetDirectory . $newFileName;
           
        
            // Move the uploaded file to the target directory
            if (move_uploaded_file($tmpName, $targetFilePath)) {
                $imageNames[] = $newFileName; // Store the file name in the array
            }
        }

        $concatenatedImageNames = implode(',', $imageNames);

        // Image upload successful, proceed with inserting the comment into the table
        $query = "INSERT INTO `comments` (product_id, user_id, rating, image, comment_text)
                  VALUES ('$productId', '$userId', '$rating', '$concatenatedImageNames', '$commentText')";

        if ($conn->query($query) === true) {
            $response[$status_keyword] = true;
            $response[$message_keyword] = $addComment_successful_keyword;
        } else {
            $response[$status_keyword] = false;
            $response[$message_keyword] = $addComment_fail_keyword;
        }
    }
} else {
    $response[$status_keyword] = false;
    $response[$message_keyword] = $wrongRequest_message_keyword;
}

header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);
