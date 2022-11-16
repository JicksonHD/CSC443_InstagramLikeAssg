<?php 

include("db_connection.php");

$response = [];


if(isset($_GET['comments_id'])){

    

}else{
    $response ["Error"] = "id has empty value!";
    echo json_encode($response);
    exit();
}
?>