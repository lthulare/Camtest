<?php
session_start();
require './config/database.php';
include_once 'functions.php';


if (isset($_SESSION['Username'])) {
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
		$username = $_SESSION['Username'];
		$use = " ";
		$sql = "INSERT INTO images (image, user, text) 
		  VALUES ('".$image."', '".$username."', '".$use."')";
		  $stmt = $con->prepare($sql);
		  if(!isset($_POST['commet_text']))
		  {
		  	if($stmt->execute() == 1){
				  header("location:gallery.php");
			  }
		  }
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
  }
  else header("location:visitor.php");
?>


<!DOCTYPE html>
<html>
<head>
    <title>Upload An Image</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <link href="css/style.css" rel="stylesheet" type="text/css">
    </head>
<body>
    <header>
		<div class="nav">
      <ul>
        <li class="home"><a href="index.php">Home</a></li>
		<li class="tutorials"><a  href="modify.php">Profile</a></li>
		<li class="tutorials"><a  href="cam.php">Snap</a></li>
        <li class="about"><a class = "active" href ="gallery.php">Gallery</a></li>
        <li class="contact"><a href="logout.php">Log out</a></li>      
      </ul>
    </div>
	<br>
			  <br>
			<h3 style = "float:center; text-align:center;">This is the gallery browse thru and dont forget to like and  comment</h3>
		<div id="content">

	<?php
	 if (!$img)
	 {
		 header("location:empty.php");
	 }
	 else
	foreach ($img as $pic):

	?>
	
		  <div class="pic">
			  <!--<div id='img_div'>-->
			 
			  <br>
			  <div style ="float:center; text-align:center;">
				<img src='images/<?=$pic['image'];?>' style ="width:30%; height:30%; float:center;">
				<!--<p><?=$pic['text'];?></p>--><br>
				<br> 
		  	
				<a href="like.php?type=image&image_id=<?php echo $pic['image_id']; ?>">LIKE</a>
				<p><?php echo $pic['likes']; ?> person(s) liked this.</p>
				<a href="delete.php?type=image&image_id=<?php echo $pic['image_id']; ?>">DELETE</a>
				
                <?php if(!empty($pic['liked_by'])): ?>
                <ul>
                    <?php foreach($pic['liked_by'] as $_SESSION['Username']): ?>
                    <?php echo $_SESSION['Username']?>
                    <?php endforeach; ?>
                </ul>
					</div>
				<?php endif; ?>
				<!-- <div style ="float:center; text-align:center">
				<form action="gallery_comments.php" id="commentform" method="GET">
					
					<input type= "hidden" value="<?php echo $pic['image_id']; ?>" name="image_id">
					<textarea type="text" name="commet_txt"></textarea>
					<br>
					<input type="submit" class="btn btn-primary">
					</div>
				</form> -->
				
			
				<?php
					$id = $pic['image_id'];
					$stmt = $con->prepare("SELECT * FROM comments WHERE image_id=:image_id");
					$stmt->bindValue(':image_id', $id);
					$stmt->execute();
					$comments = $stmt->fetchAll();
					echo '<table>';
					echo '<u><b><p>Comments</p></b></u>';
					for ($j=0; $j < sizeof($comments); $j++) 
					{ 	$use = $j;
						$comment = $comments[$j]['comment'];
						$comment_by = $comments[$j]['Username'];

						 
					echo'
						<div style = "text-align:center; float: center;">
						
						<tr>
							<td>'
								. $comment_by . 
								' said &nbsp;-: &nbsp;&nbsp;&nbsp;</li><td>'
								. $comment . 
								'</td>' .
							'</td>
						</tr>
						';
					}
					echo '
					</table></div>
					<br>
					
					';
					
				?>
				<div style ="float:center; text-align:center">
				<form action="gallery_comments.php" id="commentform" method="GET">
					
					<input type= "hidden" value="<?php echo $pic['image_id']; ?>" name="image_id">
					<textarea type="text" name="commet_txt"></textarea>
					<br>
					<input type="submit" class="btn btn-primary">
					</div>
				</form>
        
	<?php endforeach;?>
	
	
	<div style = "text-align: center; float: center;">
	<form method="POST" action="gallery.php" enctype="multipart/form-data" >
  	<input type="hidden" name="size" value="1000000">
	  
  	  <input type="file" name="image">
 </div>
  	
     <!-- <div>
	 <textarea 
      	id="text" 
      	cols="40" 
      	rows="4"	
      	name="image_text" 
      	placeholder="Say something about this image..."></textarea>
  	</div>-->
  	<div style = "text-align: center; float: center;">
  		<button type="submit" name="upload">UPLOAD</button>
  	</div>
  </form>
</div>
  <br>
        <br>
        <br>
        <footer>
                
                <div class="nav">
      <ul>
        <li class="home"><a href="gallery.php">Refresh</a></li>
        <li class="about"><a href= "logout.php">Log out</a></li>   
      </ul>

                </ul>
				</div>
        </footer>

</body>
</html>
