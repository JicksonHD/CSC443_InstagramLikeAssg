<?php

include("db_connection.php");

$response = [];


if(isset($_POST['user_id']) && isset($_POST['comments_id']) && isset($_POST['image_id']) && isset($_POST['content'])){


}
else{

    $response["Error"] = "Some fields are required!";
    echo json_encode($response);
    exit();
}



?>