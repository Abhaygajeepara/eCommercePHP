<?php
    try {
        $db = new PDO('mysql:dbname=ecommerce; host=localhost');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $db->query("SELECT * FROM product");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response = array();
        header("CONTENT-TYPE:JSON");
        $i =0;
        foreach ($users as $user) {
            $response[$i]['id'] = $user['id'];
                $response[$i]['description'] = $user['description'];
                $response[$i]['image'] = $user['image'];
                $response[$i]['pricing'] = $user['pricing'];
                $response[$i]['shippingcost'] = $user['shippingcost'];
                $i++;
        } 

        echo json_encode($response,JSON_PRETTY_PRINT);
                } catch(PDOException $e) {
                echo $e->getMessage();
                }   
    // $con = 
    
    // mysqli_connect("localhost","root","","ecommerce");
    
    // $response = array();
    // if($con){
    //     $sql = "select * from user";
    //     $result = mysqli_query($con,$sql);
    //     header("CONTENT-TYPE:JSON");
    //     if($result){
    //         $i = 0;
    //         while($row = mysqli_fetch_assoc($result)){
    //             $response[$i]['id'] = $row['id'];
    //             $response[$i]['email'] = $row['email'];
    //             $response[$i]['password'] = $row['password'];
    //             $response[$i]['name'] = $row['name'];
    //             $i++;
    //         }
    //         echo json_encode($response,JSON_PRETTY_PRINT);
    //     }
    // }else{
    //     echo "Connetion failed";
    //     }
