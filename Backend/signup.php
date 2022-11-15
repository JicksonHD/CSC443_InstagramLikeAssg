<?php
include("db_connection.php");

$response = [];

if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password'])){

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        $response ["Error"] = "Some field are empty";
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