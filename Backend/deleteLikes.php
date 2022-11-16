<?php 

include("db_connection.php");

$response = [];

if(isset($_GET['user_id']) && isset($_GET['image_id'])){

    $user_id = $_GET['user_id'];
    $image_id = $_GET['image_id'];

    if (empty($user_id) && empty($image_id)) {

        $response ["Error"] = "Id is empty";
        echo json_encode($response);
        exit();

    }else{

        $query1 = $mysqli->prepare("SELECT * FROM likes WHERE user_id = ?");
        $query1->bind_param("i", $user_id);
        $query1->execute();
        $result1 = $query1->get_result();

        $query2 = $mysqli->prepare("SELECT * FROM images WHERE image_id = ?");
        $query2->bind_param("i", $image_id);
        $query2->execute();
        $result2 = $query2->get_result();

        if(mysqli_num_rows($result1) != 0 && mysqli_num_rows($result2) != 0){

        $query3 = $mysqli->prepare("DELETE FROM comments WHERE user_id = ? AND image_id = ? ");
        $query3->bind_param("ii",$user_id,$image_id);
        $query3->execute();
        $response["Success"] = " Your like is deleted !";
        echo json_encode($response);
        exit();

        }else{

            $response["Error"] = "like does not exist from the first place ";
            echo json_encode($response);
            exit();
        }
    }
}

?>