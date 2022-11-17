<?php 

include("db_connection.php");
$response = [];


if (isset($_GET['user_id_hiding']) && isset($_GET['image_id']) && isset($_GET['user_id_hiddenFrom'])){

    $user_id_hiding = $_GET['user_id_hiding'];
    $img_id = $_GET['image_id'];
    $user_id_hidden_from = $_GET['user_id_hiddenFrom'];

    if (empty($user_id_hiding) || empty($img_id) || empty($user_id_hidden_from)) {
        $response ["Error"] = "Some field are empty";
        echo json_encode($response);
        exit();
    }
    else if($user_id_hidden_from == $user_id_hiding){
        $response ["Error"] = "You cannot hide image from yourself";
        echo json_encode($response);
        exit();
    }
    else{

        //Check if already hidden 
        $query = $mysqli->prepare("SELECT * FROM hidden_images WHERE user_id_hiding = ? AND user_id_hiddenFrom = ? AND image_id = ?");
        $query->bind_param("iii", $user_id_hiding, $user_id_hidden_from, $img_id);
        $query->execute();
        $result = $query->get_result();
        if (mysqli_num_rows($result) != 0) {
            $response ["Error"] = "This image is already hidden";
            echo json_encode($response);
            exit();
        }
        else{

            // Check if the user hiding the picture is the owner of the picture
            $query1 = $mysqli->prepare("SELECT * FROM images WHERE image_id = ? AND user_id = ?");
            $query1->bind_param("ii", $img_id, $user_id_hiding);
            $query1->execute();
            $result1 = $query1->get_result();

            if (mysqli_num_rows($result1) == 0) {
                $response ["Error"] = "You cannot hide this image";
                echo json_encode($response);
                exit();
            }
            else{

                // Check if user with this id exist
                $query2 = $mysqli->prepare("SELECT * FROM users WHERE user_id = ?");
                $query2->bind_param("i", $user_id_hidden_from);
                $query2->execute();
                $result2 = $query2->get_result();

                if (mysqli_num_rows($result2) == 0) {
                    $response ["Error"] = "Invalid User";
                    echo json_encode($response);
                    exit();
                }
                else{

                    $query3 = $mysqli->prepare("INSERT INTO hidden_images(user_id_hiding, user_id_hiddenFrom, image_id) VALUES (?, ?, ?)");
                    $query3->bind_param("iii", $user_id_hiding, $user_id_hidden_from, $img_id);
                    $query3->execute();
                    $response ["Success"] = "Image Hidden";
                    echo json_encode($response);
                    exit();
                }
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