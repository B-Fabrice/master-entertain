<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        include('../connection.php');
        if($conn){
            $sql = "SELECT * FROM streams INNER JOIN wishlist ON streams.stream_id = wishlist.stream_id
                where wishlist.user_id = $user_id ORDER by wishlist.wish_id DESC";
            $result = mysqli_query($conn, $sql);
            $streams = mYsqli_fetch_all($result, MYSQLI_ASSOC);

            mysqli_free_result($result);
            mysqli_close($conn);
        }
    }
    else{
        header('Location: ../index.php');
    }

    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>entertainer master</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/navbarStyle.css">
        <link rel="stylesheet" href="css/myhomeStyle.css">
        <link rel="stylesheet" href="../css/footerStyle.css">
    </head>
    <body>
        <?php include('navbar.php') ?>
        <div class="shCont">

            <?php if($streams): ?>
                <?php foreach($streams as $stream): ?>
                    <div class="clipCont">

                        <div class="post">
                            <div class="sCover">
                                <a href="clipDetail.php?stream_id=<?php echo $stream['stream_id'] ?>"><img src="<?php echo $stream['bg_image_url'] ?>" alt="cover"></a>
                            </div>
                            <div class="sDet">
                                <div class="detCont">
                                    <h3 class="title"><?php echo $stream['title'] ?></h3>
                                    <p><strong>Genre: </strong><?php echo $stream['genre'] ?></p>
                                    <p><strong>duration: </strong><?php echo $stream['duration'] ?>min</p>
                                    <p><strong>Cast: </strong> <?php echo $stream['s_cast'] ?></p>
                                    <p><strong>Price: </strong>$<?php echo $stream['price'] ?></p>                        
                                </div>
                            </div>
                        </div>

                        <div class="btnCont">
                            <a class="wishlist" href="wishlist.php?stream_id=<?php echo $stream['stream_id'] ?>"><span>&star;</span></a>
                            <a class="watch" href="myShow.php?stream_id=<?php echo $stream['stream_id'] ?>">Watch</a>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>empty wishlist</p>
            <?php endif; ?>

        </div>

        <?php include('../footer.php') ?>

        <script>
            var act = document.querySelector('#wish');
            act.classList.add("active");
        </script>
    </body>
</html>