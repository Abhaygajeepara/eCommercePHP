<?php
require_once('../includes/config.php');
require_once('../includes/keyboard.php');
$userId = $_GET['userId'];
try {

    $response = array();
    $query = "select * from user where id = $userId";
    $result =  $conn->query($query);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response['id'] = $row['id'];
            $response['email'] = $row['email'];
            $response['password'] = $row['password'];
            $response['name'] = $row['name'];
        }
        $mainResponse[$data_keyword] = $response;
        $mainResponse[$status_keyword] = true;
        $mainResponse[$message_keyword] = $successfulMessage_keyword;
    }
} catch (Exception $e) {
    $mainResponse['status'] = false;
}
header("CONTENT-TYPE:JSON");
echo json_encode($mainResponse, JSON_PRETTY_PRINT);

?>
