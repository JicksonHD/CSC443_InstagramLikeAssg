<?php

include("db_connection.php");


$response = [];

if (isset($_POST['user_id']) && isset($_FILES['url']) && isset($_POST['description']) && isset($_POST['submit'])){
    $user_id = $_POST['user_id'];
    $description = $_POST['description'];
    

    $img_name = $_FILES['url']['name'];
    $img_size = $_FILES['url']['size'];
    $tmp_name = $_FILES['url']['tmp_name'];
    $error = $_FILES['url']['error'];

    if ($error === 4){
        //if no file was added , its going to give us an error = 4 in the console
        $response ["Error"] = "No Photo to add";
        echo json_encode($response);
        exit();
    }
    else if($error === 0){
        // if file is too large, its going to give us an error = 0 in the console
        if($img_size > 125000){
            $response ["Error"] = " Sorry photo is too large";
            echo json_encode($response);
            exit();  
        }
        else{
        //Getting the image's path
        $img_extension = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_extension_lc = strtolower($img_extension);

        $allowed_extension = array("jpg", "jpeg", "png");
            //Checking for file extension
            if(in_array($img_extension_lc, $allowed_extension)){
                // Check if user with this id that is uploading the photo exist
                $query1 = $mysqli->prepare("SELECT * FROM users WHERE user_id = ?");
                $query1->bind_param("i", $user_id);
                $query1->execute();
                $result1 = $query1->get_result();

                if (mysqli_num_rows($result1) == 0) {
                    //The user id that is uploading this pic does not exist
                    $response ["Error"] = "Invalid User";
                    echo json_encode($response);
                    exit();
                }

                else{
                     // Uploadng te image on our server in uploads folder
                     $new_img_name = uniqid("IMG- ", true).".".$img_extension_lc;
                     $img_upload_path = 'images/'.$new_img_name;
                     move_uploaded_file($tmp_name, $img_upload_path);
                     // Insert the image into the database
                     $query = $mysqli->prepare("INSERT INTO images(user_id, url, description) VALUES (?, ?, ?)");
                     $query->bind_param("iss", $user_id, $new_img_name, $description);
                     $query->execute();
                     $response ["Success"] = "Image Added";
                     echo json_encode($response);
                     exit();
                }
            }
            else{

                $response ["Error"] = " You can't upload files of this type";
                echo json_encode($response);
                exit();
            }
        }
    }
} else{
    $response ["Error"] = "Some field are required";
    echo json_encode($response);
    exit();
}



?>