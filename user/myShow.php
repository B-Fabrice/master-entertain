<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        include('../connection.php');
        if($conn){
            if(isset($_GET['stream_id'])){
                $id = mysqli_real_escape_string($conn, $_GET['stream_id']);
                $sql = "SELECT * FROM streams WHERE stream_id = $id";
            
                $result = mysqli_query($conn, $sql);
                $stream = mysqli_fetch_assoc($result);
            
                mysqli_free_result($result);
                mysqli_close($conn);
            }
            else{
                header('Location: index.php');
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
        <link rel="stylesheet" href="css/myShowStyle.css">
        <link rel="stylesheet" href="../css/footerStyle.css">
        <title><?php echo $stream['title'] ?></title>
    </head>
    <body>
        <?php include('navbar.php') ?>

        <?php if($stream): ?>
            <div class="shCont">
            <div class="shTitle">
                <h1><?php echo $stream['title'] ?></h1>
            </div>

            <div class="myshow">
                <video controls autoplay muted>
                    <source src="<?php echo $stream['file_url'] ?>" type="video/mp4">
                    Your browser does not support HTML5 video.
                </video>
            </div>
        </div>
        <?php else: ?>
            <?php header('Location: index.php') ?>
        <?php endif; ?>

        <?php include('../footer.php') ?>

    </body>
</html>