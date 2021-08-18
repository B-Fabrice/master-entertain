<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/navbarStyle.css">
        <link rel="stylesheet" href="css/liveStyle.css">
        <link rel="stylesheet" href="../css/footerStyle.css">
        <title>live Stream</title>
    </head>
    <body>
        <?php include('navbar.php') ?>

        <div class="comingsoon">
            <p>this page is coming soon</p>
        </div>
        
        <?php include('../footer.php') ?>

        <script>
            var act = document.querySelector('#live');
            act.classList.add("active");
        </script>
    </body>
</html>