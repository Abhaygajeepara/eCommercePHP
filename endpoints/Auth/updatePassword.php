<?php
require_once('../includes/config.php');
require_once('../includes/keyword.php');

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the current password, new password, and renew password from the POST data
    $user_id = isset($_POST['userId']) ? $_POST['userId'] : '';
    $currentPassword = isset($_POST['currentPassword']) ? $_POST['currentPassword'] : '';
    $newPassword = isset($_POST['newPassword']) ? $_POST['newPassword'] : '';
    $renewPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';

    // Check if all parameters are provided and not empty
    if (!empty($user_id) &&!empty($currentPassword) && !empty($newPassword) && !empty($renewPassword)) {

        // Check if the new password and renew password match
        if ($newPassword === $renewPassword) {

            try {
                
                $query = "SELECT * FROM user WHERE id = '{$user_id}'";

               
                $result = $conn->query($query);
                if ($result) {
                    $row = mysqli_fetch_assoc($result);

                    
                    if ($row['password'] === $currentPassword) {
                        
                        $updateQuery = "UPDATE user SET password = '{$newPassword}' WHERE id = '{$user_id}'";

                        
                        $updateResult = $conn->query($updateQuery);

                        if ($updateResult) {
                            $response[$status_keyword] = true;
                            $response[$message_keyword] = $password_updated_message;
                        } else {
                            $response[$status_keyword] = false;
                            $response[$message_keyword] = $password_update_failed_message;
                        }
                    } else {
                        $response[$status_keyword] = false;
                        $response[$message_keyword] = $incorrect_current_password_message;
                    }
                }
            } catch (Exception $e) {
                $response[$status_keyword] = false;
                $response[$message_keyword] = $internal_message_keyword;
            }
        } else {
            $response[$status_keyword] = false;
            $response[$message_keyword] = $new_password_mismatch_message;
        }
    } else {
        $response[$status_keyword] = false;
        $response[$message_keyword] = $missing_parameter_keyword;
    }
} else {
    $response[$status_keyword] = false;
    $response[$message_keyword] = $wrongRequest_message_keyword;
}


header("CONTENT-TYPE:JSON");


echo json_encode($response, JSON_PRETTY_PRINT);
?>
