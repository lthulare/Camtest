<?php

require './config/database.php';


$con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
$stmt = $con->query("
                    SELECT
                    images.image_id,
                    images.image,
                    COUNT(likes.like_id) AS likes,
                    GROUP_CONCAT(users.Username SEPARATOR '|') AS liked_by
                    
                    FROM images
                    LEFT JOIN likes
                    ON images.image_id = likes.image_id
                    LEFT JOIN users
                    ON likes.user = users.Username
                    GROUP BY images.image_id
                    ");
$stmt->execute();
    
while($result = $stmt->fetch(PDO::FETCH_ASSOC))
{
    $result['liked_by'] = $result['liked_by'] ? explode('|', $result['liked_by'] ) : [];
    $img[] = $result;
}
// echo '<pre>'; print_r($img);echo '</pre>';
?>

<?php
try{
	// Create database connection
	$con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
	// Initialize message variable
	$msg = "";
  
	// If upload button is clicked ...
	if (isset($_POST['upload'])) {
		// Get image name
		$image = $_FILES['image']['name'];
		// Get text
	//$image_text = $_POST['image_text'];
  
		// image file directory
		$target = "images/".basename($image);
		echo $username = $_SESSION['Username'];
  
		// $sql = "INSERT INTO images (image, user, text) 
		//   VALUES ('".$image."', '".$username."', '".$image_text."')";
		//   $stmt = $con->prepare($sql);
		//   $stmt->execute();
		// execute query
  
		if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
			$msg = "Image uploaded successfully";
		}else{
			$msg = "Failed to upload image";
		}
	}
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  $stmt = $con->prepare("SELECT * FROM images");
	  $stmt->bindParam(':images', $images);
	  $stmt->execute();
	  $result = $stmt->fetch();
	//$result = mysqli_query($con, "SELECT * FROM images");
  }
  catch(PDOException $e)
  {
	  echo "connection failed: " . $e->getMessage();
  }
?>


<!DOCTYPE html>
<html>
<head>
    <title>Public Gallery</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <link href="css/style.css" rel="stylesheet" type="text/css">
    </head>
<body>
    <header>
		<div class="nav">
      <ul>
        <li class="home"><a href="index.php">Home</a></li>
        <li class="tutorials"><a href="login.php">Login</a></li>
        <li class="about"><a class = "active" href= "gallery.php">Gallery</a></li>
        <li class="contact"><a href="signup.php">Register</a></li>      
      </ul>
    </div>
		<div id="content">
  <br><br><br>
	<?php foreach ($img as $pic):?>
			  <div id='img_div'>
			  <div style ="float:center; text-align:center;">
				<img src='images/<?=$pic['image'];?>' style ="width:30%; height:30%; float:center;">
				<!--<p><?=$pic['text'];?></p>--><br>
				<br> 
				
				<p><?php echo $pic['likes']; ?> person(s) liked this.</p>
				
                <?php if(!empty($pic['liked_by'])): ?>
                <ul>
                    <?php foreach($pic['liked_by'] as $_SESSION['Username']): ?>
                    <?php echo $_SESSION['Username'] ?>
                    <?php endforeach; ?>
                </ul>
				<?php endif; ?>
                <br>
                <p>Comments</p><br>
                <ul>
				<br>
				<?php
					$id = $pic['image_id'];
					$stmt = $con->prepare("SELECT * FROM comments WHERE image_id=:image_id");
					$stmt->bindValue(':image_id', $id);
					$stmt->execute();
					$comments = $stmt->fetchAll();
					echo '<table><ul>';
					for ($j=0; $j < sizeof($comments); $j++) 
					{ 
						$comment = $comments[$j]['comment'];
						$comment_by = $comments[$j]['Username'];
					echo'
						<tr>
							<td>'
								. $comment_by .
								' said &nbsp;-: &nbsp;&nbsp;&nbsp;</li><td>' .
								' - </li><td>'
								. $comment . 
								'<br></td>' .
							'</td>
						</tr>
						';
					}
					echo '
					</ul></table>
					';
				?>

				
        </div>
        <br>
	<?php endforeach; ?>
	

  <br>
        <br>
        <br>
        <footer>
                <ul class="foot-nav">
                <div class="nav">
      <ul>
        <li class="home"><a href="visitor.php">Refresh</a></li>
        
        <li class="about"><a href= "login.php">Log in</a></li>   
      </ul>
    </div>
                </ul>
        </footer>

</body>
</html>
