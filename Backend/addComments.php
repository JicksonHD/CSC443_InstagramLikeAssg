<?php

include("db_connection.php");

$response = [];


if(isset($_POST['image_id']) && isset($_POST['user_id']) && isset($_POST['content'])){

    $user_id = $_POST['user_id'];
    $content = $_POST['content'];
    $image_id = $_POST['image_id'];

    if (empty($user_id) || empty($image_id) || empty($content)) {

        $response ["Error"] = "Some fields are empty";
        echo json_encode($response);
        exit();

    }else{

                $query1 = $mysqli->prepare("SELECT * FROM images WHERE image_id = ?");
                $query1->bind_param("i", $image_id);
                $query1->execute();
                $result1 = $query1->get_result();

                if (mysqli_num_rows($result1) == 0) {
                    //Checking if we have a image with this id to comment on from the first place
                    $response ["Error"] = "There is no image to comment on";
                    echo json_encode($response);
                    exit();
                }else{

                    $query = $mysqli->prepare("INSERT INTO comments (image_id,user_id,content) VALUES (?,?,?)");
                    $query->bind_param("iis", $image_id, $user_id,$content);
                    $query->execute();
                    $response ["Success"] = "Comment Added";
                    echo json_encode($response);
                    exit();

                }
    }

}else{

    $response["Error"] = "Some fields are required!";
    echo json_encode($response);
    exit();

}



?>