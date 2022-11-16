<?php

include("db_connection.php");


$response = [];

if (isset($_POST['user_id']) && isset($_FILES['url']) && isset($_POST['description']) && isset($_POST['submit'])){

    $user_id = $_POST['user_id'];
    $description = $_POST['description'];

    $img_name = $_FILES['url']['name'];
    $img_size = $_FILES['url']['size'];
    $tmp_name = $_FILES['url']['tmp_name'];
    $error = $_FILES['url']['error'];

    

}
else{
    $response ["Error"] = "Some field are required";
    echo json_encode($response);
    exit();
}


?>