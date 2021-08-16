<?php
    if(isset($_POST['submit'])){
        if(isset($_FILES['image'])){
            $img = $_FILES['image'];
            $imgName = $img['name'];
            echo $imgName;
            $mysize =  getimagesize($img['tmp_name']);

            $thumb = imagecreatetruecolor(600, 600);
            $source = imagecreatefromjpeg('deo.jpg');

            imagecopyresized($thumb, $source, 0, 0, 0, 0, 600, 600, 3840, 2160);
            $imgDestinationPath = '/'.$imgName;
        }
        else{
            echo "no image uploaded";
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>file</title>
</head>
<body>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="image">
        <input type="submit" name="submit" value="upload">
    </form>
    
</body>
</html>