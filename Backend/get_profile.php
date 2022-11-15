<?php

include("db_connection.php");

$response = [];

if (isset($_GET['user_id'])) {

    
}
else{
    $response ["Error"] = "User not found ! ";
    echo json_encode($response);
    exit();
}
?>

?>