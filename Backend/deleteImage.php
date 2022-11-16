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

        // Deleteing the image from images file
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
        $query3 = $mysqli->prepare("SELECT * FROM comments WHERE comments_id = ?");
        $query3->bind_param("i",$comments_id);
        $query3->execute();
        $result1 = $query->get_result();

        if(mysqli_num_rows($result1) != 0){   

        $query4 = $mysqli->prepare("DELETE FROM comments WHERE comments_id = ?");
        $query4->bind_param("i",$comments_id);
        $query4->execute();
        $response["Success"] = " Your comment is deleted !";
        echo json_encode($response);
        exit();

        }else{

        $response["Error"] = "Comment does not exist from the first place ";
        echo json_encode($response);
        exit();

        }

        //Check if like id exists

        $query5 = $mysqli->prepare("SELECT * FROM likes WHERE user_id = ?");
        $query5->bind_param("i", $user_id);
        $query5->execute();
        $result2 = $query5->get_result();

        $query6 = $mysqli->prepare("SELECT * FROM images WHERE image_id = ?");
        $query6->bind_param("i", $image_id);
        $query6->execute();
        $result3 = $query2->get_result();

        if(mysqli_num_rows($result2) != 0 && mysqli_num_rows($result3) != 0){

            $query7 = $mysqli->prepare("DELETE FROM comments WHERE user_id = ? AND image_id = ? ");
            $query7->bind_param("ii",$user_id,$image_id);
            $query7->execute();
            $response["Success"] = " Your like is deleted !";
            echo json_encode($response);
            exit();
    
            }else{
    
                $response["Error"] = "like does not exist from the first place ";
                echo json_encode($response);
                exit();
            }

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