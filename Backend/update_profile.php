<?php

include("db_connection.php");

$response = [];

if (isset($_POST['user_id']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email'])){

    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    if (empty($user_id) || empty($first_name) || empty($last_name) || empty($email)) {
        $response ["Error"] = "Some fields are empty";
        echo json_encode($response);
        exit();
    }
}
else{
    $response ["Error"] = "Some field are required";
    echo json_encode($response);
    exit();
}

?>