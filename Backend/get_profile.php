<?php

include("db_connection.php");

$response = [];

if (isset($_GET['user_id'])) {
    //Checking if id has a value in database or not
    $user_id = $_GET['user_id'];
    if (empty($user_id)) {
        $response ["Error"] = "Id is empty";
        echo json_encode($response);
        exit();
    }
    else{
        // Check if user with this id exist
        $query = $mysqli->prepare("SELECT * FROM users WHERE user_id = ? ");
        $query->bind_param("i", $user_id);
        $query->execute();
        $result = $query->get_result();

        // if exist display its info
        if (mysqli_num_rows($result) != 0) {
            $user_info = mysqli_fetch_assoc($result);
            $response["Success"] = $user_info;
            echo json_encode($response);
            exit();
        }   
        else{
            $response["Error"] = "User not found!!";
            echo json_encode($response);
            exit();
        }
    }
}
else{
    $response ["Error"] = "id has empty value in db !";
    echo json_encode($response);
    exit();
}
?>

?>