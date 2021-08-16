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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $stream['title'] ?></title>
    <link rel="stylesheet" href="css/navbarStyle.css">
    <link rel="stylesheet" href="css/clipDetailStyle.css">
    <link rel="stylesheet" href="../css/footerStyle.css">
</head>
<body>
    <?php include('navbar.php') ?>

    <?php if($stream): ?>
        <div class="showD">
            <div class="title">
                <h2><?php echo $stream['title'] ?></h2>
            </div>
            <div class="coverIm">
                <img src="<?php echo $stream['bg_image_url'] ?>" alt="cover">
            </div>
            <div class="Detail">
                <p><strong>Genre: </strong><?php echo $stream['genre'] ?></p>
                <p><strong>duration: </strong> <?php echo $stream['duration'] ?>min</p>
                <p><strong>Cast: </strong><?php echo $stream['s_cast'] ?></p>
                <p><strong>Price: </strong>$<?php echo $stream['price'] ?></p>

                <div class="about">
                    <p><?php echo $stream['about'] ?></p>
                </div>
            </div>

            <div class="btnCont">
                <a class="wishlist" href=""><span>&star;</span></a>
                <a class="download" href="downloaded.php?stream_id=<?php echo $stream['stream_id'] ?>"><span>&DownArrowBar;</span></a>
                <a class="watch" href="watched.php?stream_id=<?php echo $stream['stream_id'] ?>">Watch</a>
            </div>
        </div>
    <?php else: ?>
        <?php header('Location: index.php') ?>
    <?php endif; ?>
    
    <?php include('../footer.php') ?>
        
</body>
</html>