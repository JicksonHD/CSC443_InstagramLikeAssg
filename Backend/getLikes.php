<?php 


include("db_connection.php");

$response = [];

if (isset($_GET['image_id'])){

    $img_id = ($_GET['image_id']);

    if (empty($img_id)) {
        $response ["Error"] = "Some fields are empty";
        echo json_encode($response);
        exit();
    }
    else{
        // Check if image exist
        $query1 = $mysqli->prepare("SELECT * FROM images WHERE image_id = ?");
        $query1->bind_param("i", $img_id);
        $query1->execute();
        $result1 = $query1->get_result();
        if (mysqli_num_rows($result1) == 0) {
            $response ["Error"] = "Invalid Image";
            echo json_encode($response);
            exit();
        }
        else {
            // Check for the likes for this image
            $query2 = $mysqli->prepare("SELECT first_name, last_name FROM likes as l, users as u WHERE l.user_id = u.user_id AND l.image_id = ?");
            $query2->bind_param("i", $img_id);
            $query2->execute();
            $result2 = $query2->get_result();

            if (mysqli_num_rows($result2) == 0) {
                $response ["Error"] = "No Likes";
                echo json_encode($response);
                exit();
            }
            else{
                // Returning all likes (fisrtname, lastname)
                while($like = mysqli_fetch_assoc($result2)){
                    $response[] = $like;
                };
                // Counting the likes for this image
                $query3 = $mysqli->prepare("SELECT COUNT(image_id) FROM likes WHERE image_id = ?");
                $query3->bind_param("i", $img_id);
                $query3->execute();
                $result3 = $query3->get_result();
                $raw = mysqli_fetch_assoc($result3); 
                $total_likes = $raw["COUNT(image_id)"];
                $response["Total Likes"] = $total_likes;
                echo json_encode($response);
                exit();
            }
        }
    }
}
else{
    $response ["Error"] = "Some field are required";
    echo json_encode($response);
    exit();
}

?>