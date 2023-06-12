<?php
require_once('../includes/config.php');
require_once('../includes/keyword.php');
$response = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
if(!empty($email) && !empty($password)){
    try {
        $query = "SELECT * FROM user WHERE email = '{$email}' AND password = '{$password}'";
        $result =  $conn->query($query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            // while ($row = mysqli_fetch_assoc($result))
            if($row['email'] == $email && $password == $row['password'])
            {
                $response['id'] = $row['id'];
                $response['email'] = $row['email'];
                $response['name'] = $row['name'];
                $mainResponse[$data_keyword] = $response;
                $mainResponse[$status_keyword] = true;
            }else{
                $mainResponse[$data_keyword] = $response;
                $mainResponse[$status_keyword] = true;
                $mainResponse[$message_keyword] = $wrong_credential_keyword;
        
            }
           
        }
    } catch (Exception $e) {
        $mainResponse[$status_keyword] = false;
        $mainResponse[$message_keyword] = $internal_message_keyword;
    }
}
else{
    $mainResponse[$data_keyword] = $response;
    $mainResponse[$status_keyword] = false;
    $mainResponse[$message_keyword] = $missing_parameter_keyword;

}

}
else{
    $mainResponse[$data_keyword] = $response;
    $mainResponse[$status_keyword] = false;
    $mainResponse[$message_keyword] = $wrongRequest_message_keyword;
}

header("CONTENT-TYPE:JSON");

echo json_encode($mainResponse, JSON_PRETTY_PRINT);
?>

