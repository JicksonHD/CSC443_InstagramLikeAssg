<?php

include("db_connection.php");

$response = [];

if (isset($_POST['id']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email'])){

}
else{
    $response ["Error"] = "Some field are required";
    echo json_encode($response);
    exit();
}

?>