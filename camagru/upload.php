
<!doctype html>
<html>
    <head>
        <title>Camagru</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <link href="css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <header>
         <div class="nav">
      <ul>
        <li class="home"><a href="index.php">Home</a></li>
        <li class="tutorials"><a href="modify.php">Profile</a></li>
        <li class ="tutorials"><a href="cam.php">Snap</a></li>
        <li class="about"><a href= "gallery.php">Gallery</a></li>
        <li class="contact"><a href="logout.php">Logout</a></li>      
      </ul>
    </div>
        </header>
        <br>
        <h2 style = "text-align: center">Your image has been uploaded you can now view it in the gallery</h2>
        <br><br>
    </body>
    </html>

<?php
        
            
              try{

                session_start();

                $user = $_SESSION['Username'];
                $time = time()."$user";
                require('config/database.php');
               
                    $img = $_POST['img'];
                         # Get the image string and prepare it.
                         $img = $_POST['img'];
                         $img = str_replace('data:image/png;base64,', '', $img);
                         $img = str_replace(' ', '+', $img);
                         # decode the data.
                         $data = base64_decode($img);
                         $path = "images/$time.png";
                         $use = $time.".png";
                         file_put_contents("$path", $data);
                         //echo $_POST['stick'];
                list($width, $height) = getimagesize($_POST['stick']);

                $image1 = imagecreatefromstring(file_get_contents('./images/'.$use));
                $image2 = imagecreatefromstring(file_get_contents($_POST['stick']));
                imagecopymerge($image1, $image2, 0, 100, 0, 0, $width, $height, 100);
                imagepng($image1, './images/'.$use);

				$con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
				$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			
                

            $sql = "INSERT INTO images (image, user, text) VALUES(:photo, :user, 'nonsense')";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':photo', $use);
            $stmt->bindParam(':user', $user);
            $stmt->execute();
                //$stmt->bindParam(':photo', $path);

         }
        
        catch(PDOException $e)
        {
            echo $stmt . "<br>" . $e->getMessage();
        }
       
?>

<html>
    <body>
        <div style = "float:center; text-align:center;">
        <?php echo "<img src=$path>";?>
        </div>
        <br><br>
        <footer>
               
               <div class="nav">
     <ul>
       <li class="home"><a href="gallery.php">Gallery</a></li>
       <li class="about"><a href= "logout.php">Log out</a></li>   
     </ul>
   </div>
       </footer>

    </body>
</html>