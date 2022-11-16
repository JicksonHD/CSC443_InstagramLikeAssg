<?php

include("db_connection.php");

$response = [];


if(isset($_POST['user_id']) && isset($_POST['comments_id']) && isset($_POST['image_id']) && isset($_POST['content'])){

    $user_id = $_POST['user_id'];
    $comments_id = $_POST['comments_id'];
    $content = $_POST['content'];
    $image_id = $_POST['image_id'];
    

}
else{

    $response["Error"] = "Some fields are required!";
    echo json_encode($response);
    exit();

}



?>