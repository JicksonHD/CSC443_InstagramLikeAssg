<?php

include("db_connection.php");

$response = [];

if (isset($_POST['user_id']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email'])){

    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    if (empty($user_id) || empty($first_name) || empty($last_name) || empty($email)) {
        $response ["Error"] = "Some fields are empty";
        echo json_encode($response);
        exit();
    }

    else{
        // Check if user with this id exist in database
        $query1 = $mysqli->prepare("SELECT * FROM users WHERE user_id = ?");
        $query1->bind_param("i", $user_id);
        $query1->execute();
        $result1 = $query1->get_result();
        
        if (mysqli_num_rows($result1) == 0) {

    
            $response ["Error"] = "Invalid User";
            echo json_encode($response);
            exit();
        }
        else{
            // Check if user with the new email exist
            $query2 = $mysqli->prepare("SELECT * FROM users WHERE email = ? AND user_id != ?");
            $query2->bind_param("si", $email, $user_id);
            $query2->execute();
            $result2 = $query2->get_result();
            if (mysqli_num_rows($result2) != 0) {
                $response ["Error"] = "This email is already registered";
                echo json_encode($response);
                exit();
            }
            else{
                //Insert new email by updating db
                $query = $mysqli->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE user_id = ?");
                $query->bind_param("ssss", $first_name, $last_name, $email, $user_id);
                $query->execute();
                $response ["Success"] = "Profile Updated";
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