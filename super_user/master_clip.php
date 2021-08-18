<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        if(!$_SESSION['is_super_user']){
            header('Location: ../index.php');
        }
        include('../connection.php');
        if($conn){
            if(isset($_GET['stream_id'])){
                $id = mysqli_real_escape_string($conn, $_GET['stream_id']);
                $sql = "SELECT * FROM streams WHERE stream_id = $id";

                $result = mysqli_query($conn, $sql);
                $stream = mysqli_fetch_assoc($result);

                mysqli_free_result($result);

                $stream_id =  $stream['stream_id'];
                $watch_sql = "SELECT * FROM stream_watches WHERE stream_id = $stream_id";
                $watches = mysqli_query($conn, $watch_sql);
                $watch_count = mysqli_num_rows($watches);

                $downloads_sql = "SELECT * FROM stream_downloads WHERE stream_id = $stream_id";
                $downloads = mysqli_query($conn, $downloads_sql);
                $download_count = mysqli_num_rows($downloads);

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
        <title>show Details</title>
        <link rel="stylesheet" href="css/navbarStyle.css">
        <link rel="stylesheet" href="css/master_clipStyle.css">
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
                    <p><strong>Cast: </strong> <?php echo $stream['s_cast'] ?></p>
                    <p><strong>Price: </strong>$<?php echo $stream['price'] ?></p>
                    <div><strong><?php echo $watch_count ?> watches</strong></div>
                    <div><strong><?php echo $download_count ?> download</strong></div>
                    <div><p><?php echo $stream['about'] ?></p></div>
                </div>
                <div class="deletebtn"><button id="dltbtn">delete</button></div>
        </div>
        <?php else: ?>
            <p>no seach stream found</p>
        <?php endif; ?>
        
        <?php include('../footer.php') ?>

        <script>
            var btn = document.querySelector("#dltbtn");

            btn.onclick = function() {
                var conf = confirm("are you sure to delete this stream.\nit will be removed from database!\npress ok to delete it.");
                if(conf == true){
                    var link = document.createElement('a'),
                    url = document.createAttribute('href');
                    url.value = "deleteStream.php?stream_id=<?php echo $stream_id ?>";
                    link.attributes.setNamedItem(url);
                    link.click();
                }
            }
        </script>
            
    </body>
</html>