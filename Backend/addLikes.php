<?php 

include("db_connection.php");

$response = [];

if(isset($_POST['user_id']) && $_POST['image_id']){

    $user_id = $_POST['user_id'];
    $image_id = $_POST['image_id'];

    if (empty($user_id) || empty($image_id)) {

        $response ["Error"] = "Some fields are empty";
        echo json_encode($response);
        exit();
    }else{

        $query1 = $mysqli->prepare("SELECT * FROM images WHERE image_id = ?");
        $query1->bind_param("i", $image_id);
        $query1->execute();
        $result1 = $query1->get_result();

        if (mysqli_num_rows($result1) == 0) {
            //Checking if we have a image with this id to like from the first place
            $response ["Error"] = "There is no image to like";
            echo json_encode($response);
            exit();

        }else{

            $query = $mysqli->prepare("INSERT INTO likes (user_id,image_id) VALUES (?,?)");
            $query->bind_param("ii", $user_id, $image_id);
            $query->execute();
            $response ["Success"] = "Like Added";
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