<?php

include("db_connection.php");

$response = [];

if (isset($_POST['email']) && isset($_POST['password'])){

    $email = $_POST['email'];
    $password = mysqli_real_escape_string($mysqli, stripslashes(htmlspecialchars($_POST['password'])));

    if(empty($email) || empty($password)){

        $response['Error'] = "Some fields are missing";
        echo json_encode($response);
        exit();
    }
    else{

        //authentication
        $query1 = $mysqli->prepare("SELECT * FROM users WHERE email = ? ");
        $query1->bind_param("s", $email);
        $query1->execute();
        $result = $query1->get_result();
        
        if (mysqli_num_rows($result) != 0) {
            
            $user = mysqli_fetch_assoc($result);
            $db_password = $user["password"];

            if(password_verify($password, $db_password)){

                $response["success"] = $user;
                echo json_encode($response);
                exit();
                
            }else{
                echo($password);
                echo($db_password);
                $response["error"] = "Wrong password";
                echo json_encode($response);
                exit();
            }
    }else{
        $response["error"] = "Mail not found";
        echo json_encode($response);
        exit();
    }
    }


}


?>