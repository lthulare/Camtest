

<?php
session_start();
require 'config/database.php';

if (isset($_SESSION['Username'])) {

    if (!empty($_POST['username'])) {

        $username = trim(htmlspecialchars($_POST['username']));
        $user = $_SESSION['Username'];
        $use = $user;

        try {
            $con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = "UPDATE users SET Username = :user WHERE Username = :userid";
            $stmt = $con->prepare($sql);

            $stmt->bindParam(':user', $username);
            $stmt->bindParam(':userid', $user);

            if ($stmt->execute()) {
                echo "Username has been updated will redirect you to log in page in 6 seconds";
                header('Refresh: 4; URL=logout.php');
            } else {
                echo "Something went wrong or Username has been taken";
            }
        } catch (Exception $e) {
            echo $stmt . "<br>" . $e->getMessage();
        }
        $con = null;
    }

    if (!empty($_POST['email'])) {

        $email = trim(htmlspecialchars($_POST['email']));
        $user = $_SESSION['Username'];

        try {
            $con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = "UPDATE users SET email = :email WHERE Username = :userid";
            $stmt = $con->prepare($sql);

            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':userid', $user);

             if($stmt->execute()) {
                echo "email has been updated";
            } else {
                echo "Something went wrong or email has been taken";
            }
        } catch (Exception $e) {
            echo $stmt . "<br>" . $e->getMessage();
        }
        $con = null;
    }

    if (!empty($_POST['pwd'])) {

        $pwd = trim(htmlspecialchars($_POST['pwd']));
        $hashpass = password_hash($pwd, PASSWORD_BCRYPT);
        $user = $_SESSION['Username'];

        try {
            $con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = "UPDATE users SET Passwrd = :passwords WHERE Username = :userid";
            $stmt = $con->prepare($sql);

            $stmt->bindParam(':passwords', $hashpass);
            $stmt->bindParam(':userid', $user);

            if ($stmt->execute()) {
                echo "Password has been updated";
            } else {
                echo "Something went wrong try retyping password";
            }
        } catch (Exception $e) {
            echo $stmt . "<br>" . $e->getMessage();
        }
        $con = null;
	}

}
 else {
    echo "You need to be logged in to access this page";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
        <header>
		<div class="nav">
      <ul>
        <li class="home"><a href="index.php">Home</a></li>
        <li class="tutorials"><a class href="modify.php">Profile</a></li>
        <li class="about"><a href= "gallery.php">Gallery</a></li>
        <li class="contact"><a href="logout.php">Log out</a></li>      
      </ul>
    </div>
		</header>
		<div style = "text-align: center; text-align: center">
        <form class="box2" action="modify.php" method="post">
        <h1>Update Username</h1>
		<input type="text" placeholder="Username" name="username" required>
		<br>
		<br>
        <input type="submit" name="signup" value="UPDATE" class = "btn btn-primary">
    </form>

	<form class="box2" action="modify.php" method="post">
        <h1>Update Email</h1>
		<input type="text" placeholder="Email address" name="email" required>
		<br>
		<br>
        <input type="submit" name="signup" value="UPDATE" class = "btn btn-primary">
    </form>


	<form class="box2" action="modify.php" method="post">
        <h1>Update Password</h1>
		<input type="password" placeholder="Password" name="pwd" required>
		<br>
		<br>
        <input type="submit" name="signup" value="UPDATE" class = "btn btn-primary">
    </form>
	<br>
	<br>
	<footer>
                <ul class="foot-nav">
                <div class="nav">
      <ul>
        <li class="home"><a href="modify.php">Refresh</a></li>
        <li class="about"><a href= "signup.php">Log out</a></li>   
      </ul>
    </div>
        </footer>
</body>
</html>
