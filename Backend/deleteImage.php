<?php



include("db_connection.php");
include("deleteComments.php");


$response = [];


if(isset($_GET['image_id'])){
    
    //Checking if id has a value in database or not
    $image_id = $_GET['image_id'];
    if (empty($image_id)) {
        $response ["Error"] = "Id is empty";
        echo json_encode($response);
        exit();
    }
    else{

     // Check if image id with this id exist
     $query = $mysqli->prepare("SELECT * FROM images WHERE image_id = ?");
     $query->bind_param("i",$image_id);
     $query->execute();
     $result = $query->get_result();

        if(mysqli_num_rows($result) != 0){

        // Deleteing the image from uploads file
        $image = $result->fetch_assoc();
        $img_url = $image["url"];
        $img_path = 'images/'.$img_url;
        unlink($img_path);    

        $query2 = $mysqli->prepare("DELETE FROM images WHERE image_id = ?");
        $query2->bind_param("i",$image_id);
        $query2->execute();
        $response["Success"] = " Your image is deleted !";
        echo json_encode($response);

         // Check if comment id exists
        $query = $mysqli->prepare("SELECT * FROM comments WHERE comments_id = ?");
        $query->bind_param("i",$comments_id);
        $query->execute();
        $result = $query->get_result();

        if(mysqli_num_rows($result) != 0){   

        $query2 = $mysqli->prepare("DELETE FROM comments WHERE comments_id = ?");
        $query2->bind_param("i",$comments_id);
        $query2->execute();
        $response["Success"] = " Your comment is deleted !";
        echo json_encode($response);
        exit();

        }else{

        $response["Error"] = "Comment does not exist from the first place ";
        echo json_encode($response);
        exit();

        }

        //Check if like id exists

    }else{
        $response["Error"] = "Image not found";
        echo json_encode($response);
        exit();
        }
    }

}else{
    $response ["Error"] = "id has empty value!";
    echo json_encode($response);
    exit();
}

?>
























?>