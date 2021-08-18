<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        if(!$_SESSION['is_super_user']){
            header('Location: ../index.php');
        }
        $user_id = $_SESSION['user_id'];
        include('../connection.php');
        if($conn){
            if(isset($_POST['submit'])){
                $title = htmlspecialchars($_POST['title']);
                $bg_img = $_FILES['bg_image'];
                $genre = htmlspecialchars($_POST['genre']);
                $cast = htmlspecialchars($_POST['cast']);
                $file = $_FILES['file'];
                $duration = htmlspecialchars($_POST['duration']);
                $price = htmlspecialchars($_POST['price']);
                $about = htmlspecialchars($_POST['about']);

                $img_name = $bg_img['name'];
                $img_tpName = $bg_img['tmp_name'];
                $img_error = $bg_img['error'];
                $img_size = $bg_img['size'];
                $img_type = $bg_img['type'];

                $imgExt = explode('.', $img_name);
                $imgActualExt = strtolower(end($imgExt));

                $allowed = array('jpg', 'jpeg', 'png');
                if(in_array($imgActualExt, $allowed)){
                    if($img_error === 0){
                        $imgNewName = "img" . date("dym") . time() . "." . $imgActualExt;
                        $imgDestinationPath = '../uploads/img/'.$imgNewName;
                    }
                }

                $file_name = $file['name'];
                $file_tpName = $file['tmp_name'];
                $file_error = $file['error'];
                $file_size = $file['size'];
                $file_type = $file['type'];

                $fileExt = explode('.', $file_name);
                $fileActualExt = strtolower(end($fileExt));

                $allowed = array('mp4', 'webm', 'wmv');
                if(in_array($fileActualExt, $allowed)){
                    if($file_error === 0){
                        $fileNewName = "stream" . date("dym") . time() . "." . $fileActualExt;
                        $fileDestinationPath = '../uploads/streams/'.$fileNewName;
                    }
                }

                $sql = "INSERT INTO streams (title, bg_image_url, genre, s_cast, file_url, duration, price, about, user_id) 
                    VALUES ('$title', '$imgDestinationPath', '$genre', '$cast', '$fileDestinationPath', '$duration', '$price', '$about', $user_id)";

                if(mysqli_query($conn, $sql)){
                    move_uploaded_file($img_tpName, $imgDestinationPath);
                    move_uploaded_file($file_tpName, $fileDestinationPath);
                    header('Location: index.php');
                }
            }
        }
    }
    else{
        header('Location: ../index.php');
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/navbarStyle.css">
        <link rel="stylesheet" href="css/master_addClipStyle.css">
        <link rel="stylesheet" href="../css/footerStyle.css">
        <title>add clip</title>
    </head>
    <body>
        <?php include('navbar.php') ?>

        <div class="myClip">
            <div class="clipCOnt">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                    <label for="title">Title</label><br>
                    <input type="text" name="title"><br>

                    <label for="bg_image">Stream Background</label><br>
                    <input type="file" name="bg_image"><br>

                    <label for="genre">Genre</label><br>
                    <input type="text" name="genre"><br>

                    <label for="cast">cast</label><br>
                    <input type="text" name="cast"><br>

                    <label for="duration">Stream File</label><br>
                    <input type="file" name="file"><br>

                    <label for="duration">Duration</label><br>
                    <input type="datetime" name="duration"><br>

                    <label for="price">price</label><br>
                    <input type="text" name="price"><br>

                    <label for="about">about</label><br>
                    <textarea name="about" cols="30" rows="10"></textarea>

                    <input type="submit" name="submit" value="add stream">
                </form>
            </div>
        </div>

        <?php include('../footer.php') ?>
        
    </body>
</html>