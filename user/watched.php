<?php
    session_start();
    if(isset($_GET['stream_id'])){
        include('../connection.php');
        if(isset($_SESSION['user_id'])){
            if($_SESSION['is_user']){
                $user_id = $_SESSION['user_id'];
                $stream_id = $_GET['stream_id'];

                $ex_sql = "SELECT * FROM stream_watches WHERE stream_id = $stream_id AND user_id = $user_id";
                $is_exist = mysqli_query($conn, $ex_sql);
                $stream_exist = mysqli_fetch_all($is_exist, MYSQLI_ASSOC);

                if(!array_filter($stream_exist)){
                    $sql = "INSERT INTO stream_watches(stream_id, user_id)
                    VALUES($stream_id, $user_id)";
                    $result = mysqli_query($conn, $sql);
                    if($result){
                        header('Location: myShow.php?stream_id='.$stream_id);
                    }
                }
                else{               
                    header('Location: myShow.php?stream_id='.$stream_id);
                }
            }
            else{
                header('Location: ../index.php');
            }
        }
        else{
            header('Location: ../index.php');
        }
    }
    else {
        header('Location: index.php');
    }
?>