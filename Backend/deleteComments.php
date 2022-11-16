<?php 

include("db_connection.php");

$response = [];


if(isset($_GET['comments_id'])){

    $comments_id = $_GET['comments_id'];

    if (empty($comments_id)) {
        $response ["Error"] = "Id is empty";
        echo json_encode($response);
        exit();

    }else{

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

    }

}else{
    $response ["Error"] = "id has empty value!";
    echo json_encode($response);
    exit();
}
?>