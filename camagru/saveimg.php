
<?php

/*
<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$imageurl = $_POST['key'];
// echo $imageurl;
$token = uniqid();
$id = $token . ".png";
file_put_contents($id, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$imageurl)));
$dest = imagecreatefrompng($id);
$src = imagecreatefrompng($_POST['overlay']);
imagecopy($dest, $src, 0, 0, 0, 0, 500, 500);
header('Content-type: image/png');
imagejpeg($dest, $id, 100);
imagedestroy($dest);
imagedestroy($src);
echo $_POST['overlay'];
?>*/



session_start();

$user = $_SESSION['Username'];

require('config/database.php');

/*$directory = "uploads/";
    $files = scandir($directory);
    for($i = 0 ; $i < count($files) ; $i++){
        if($files[$i] !='.' && $files[$i] !='..')
        { echo $files[$i]; echo "<br>";
            $file_new[] = $files[$i];
        }
    }
    echo $num_files = count($file_new);
    $n = $i - 2;
*/
    echo $_POST['img'].'<br>';

    $img = $_POST['img'];
         # Get the image string and prepare it.
         $img = $_POST['img'];
         $img = str_replace('data:image/png;base64,', '', $img);
         $img = str_replace(' ', '+', $img);
         # decode the data.
         $data = base64_decode($img);

         file_put_contents("uploads/$user$n.png", $data);
       

?>
