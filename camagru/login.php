<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'config/database.php';
try
	{
		if (!empty($_POST['Username']) || !empty($_POST['Password']))
		{
			$Username = htmlspecialchars($_POST['Username']);
			$Password = htmlspecialchars($_POST['Password']);
		if (isset($_SESSION['Username']))
		{
			die("You are already signed in!");
		}
		// Check for errors
		if (!isset($Username) || empty($Username))
		{
			echo "! Username input is invalid<br>";
		}
		else if (!isset($Password) || empty($Password) || !(strlen($Password) > 6) || (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $Password)))
		{
			echo "! Password input is invalid<br>";
			if (!(strlen($Password) > 6))
			{
				echo "! Password length is too short, must be atleast 6 characters long<br>";
			}
			if (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $Password))
			{
				echo "! Password must contain letters and digits<br>";
			}
        }
        else if (isset($Username) && !empty($Username) && isset($Password) && !empty($Password))
		{
            $con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
            // set the PDO error mode to exception
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $con->prepare("SELECT * FROM users WHERE Username = :Username");
          $stmt->bindParam(':Username', $Username);
          $stmt->execute();
          $result = $stmt->fetch();
          if (!$result)
				die('Could not access credentials through database!');
			else
			{
				if ($result['active'] == true)
				{
					$validpassword = password_verify($Password, $result['Passwrd']);
					if ($validpassword)
					{
                        echo "hello";
                        
						$_SESSION['user_id'] = $result['user_id'];
						$_SESSION['Username'] = $result['Username'];
						$_SESSION['loggedin'] = true;
						$_SESSION['logged_in'] = time();
						//$_SESSION['email_notify'] = $result['notifications'];
						print_r($_SESSION);
						header('Location: index.php');
                        exit;
                        
					} 
					else
						die('Incorrect username / password combination!');
				}
				else
					die('You have not verified your account, check your email!');
			}
		}
		else 
			die('Something went wrong...');
	}
	}
	catch(PDOException $e)
	{
		echo $stmt . "<br>" . $e->getMessage();
	}
	$conn = null;
?>

<!doctype html>
<html>
    <head>
        <title>Login</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <link href="css/style.css" rel="stylesheet" type="text/css">
    </head>
<body>
    <header>
		<div class="nav">
      <ul>
        <li class="home"><a href="index.php">Home</a></li>
        <li class="tutorials"><a class = "active" href="login.php">Login</a></li>
        <li class="about"><a href= "gallery.php">Gallery</a></li>
        <li class="contact"><a href="signup.php">Register</a></li>      
      </ul>
    </div>

    </header>
	<div style = "text-align: center; text-align: center">
	<br>
	<p>Welcome to Camagru you can now Log in into your account</p>
    <form class="box" action="" method="post">
        <h1>Login</h1>
		<input type="text" placeholder="Username" name='Username'>
		<br>
		<input type="password" placeholder="Password" name='Password'>
		<br>
		<input type="submit" name="" value="login" class ="btn btn-primary">
		<br>
        <a href="forgot_password.php"> FORGOT PASSWORD </a>

    </form>
    </div>
</body>
</html>
