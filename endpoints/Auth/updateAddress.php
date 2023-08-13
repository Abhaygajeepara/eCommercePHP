
<?php
// Include the required files
require_once('../includes/config.php');
require_once('../includes/keyword.php');

// Create an array to store the API response
$response = array();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_id = isset($_POST['userId']) ? $_POST['userId'] : '';
    $newAddress = isset($_POST['address']) ? $_POST['address'] : '';

    
    if (!empty($newAddress) && !empty($user_id)) {

        try {
            $updateQuery = "UPDATE user SET shipping_address = '{$newAddress}' WHERE id = '{$user_id}'";

            $updateResult = $conn->query($updateQuery);

            if ($updateResult) {
                $response[$status_keyword] = true;
                $response[$message_keyword] = $address_updated_message;
            } else {
                $response[$status_keyword] = false;
                $response[$message_keyword] = $address_update_failed_message;
            }
        } catch (Exception $e) {
            $response[$status_keyword] = false;
            $response[$message_keyword] = $internal_message_keyword;
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
