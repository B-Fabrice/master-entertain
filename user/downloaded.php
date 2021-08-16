<?php
    session_start();
    if(isset($_GET['stream_id'])){
        include('../connection.php');
        if(isset($_SESSION['user_id'])){
            if($_SESSION['is_user']){
                $user_id = $_SESSION['user_id'];
                $stream_id = $_GET['stream_id'];

                $sql = "SELECT * FROM streams WHERE stream_id = $stream_id";
                $result = mysqli_query($conn, $sql);
                $stream = mysqli_fetch_assoc($result);
                mysqli_free_result($result);

                $file_url = $stream['file_url'];
                $file_name = $stream['title'];
                echo "<script>
                        var link = document.createElement('a');
                        var url = document.createAttribute('href');
                        var download = document.createAttribute('download');
                        url.value = '$file_url';
                        download.value = '$file_name';
                        link.attributes.setNamedItem(url);
                        link.attributes.setNamedItem(download);
                        link.click();
                        link.remove();
                    </script>";

                $ex_sql = "SELECT * FROM stream_downloads WHERE stream_id = $stream_id AND user_id = $user_id";
                $is_exist = mysqli_query($conn, $ex_sql);
                $stream_exist = mysqli_fetch_all($is_exist, MYSQLI_ASSOC);

                if(!array_filter($stream_exist)){
                    $sql = "INSERT INTO stream_downloads(stream_id, user_id)
                    VALUES($stream_id, $user_id)";
                    $result = mysqli_query($conn, $sql);
                    mysqli_close($conn);
                }
                header("refresh: 0.01, url=clipDetail.php?stream_id=" .$stream_id);
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
