<?php
session_start();
 
include 'config/database.php'; 
require_once 'functions.php';

try {
        
        if (!empty($_POST['username']) || !empty($_POST['email']) || !empty($_POST['pwd']) || !empty($_POST['re_pwd']))
{
   
    $username       = trim(htmlspecialchars($_POST['username']));
    $email          = trim(htmlspecialchars($_POST['email']));
    $pwd            = trim(htmlspecialchars($_POST['pwd']));
    $re_pwd         = trim(htmlspecialchars($_POST['re_pwd']));
    $active         = false;
    $notifi         = true;
    $token			= md5(time().$username);
       
		if (!isset($username) || empty($username) || strlen($username) < 4)
		{
			echo "! Username input is invalid - *also check to see if username is more than 4 characters long<br>";
		}
		else if (!isset($email) || empty($email) || !(filter_var($email, FILTER_VALIDATE_EMAIL)))
		{
			echo "! Email input is invalid<br>";
		}
		else if (!isset($pwd) || empty($pwd) || !($pwd === $re_pwd) || !(strlen($pwd) > 6) || (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $pwd)))
		{
			echo "! Password input is invalid<br>";
			if (!($pwd === $re_pwd))
			{
				echo "! Password fields do not match<br>";
			}
			if (!(strlen($pwd) > 6))
			{
				echo "! Password length is too short, must be atleast 6 characters long<br>";
			}
			if (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $pwd))
			{
				echo "! Password must contain letters and digits<br>";
			}
        }
        else if ((isset($username) && !empty($username) && !(strlen($username) < 4)) 
			&& (isset($email) && !empty($email) && (filter_var($email, FILTER_VALIDATE_EMAIL))) 
			&& (isset($pwd) && !empty($pwd) && ($pwd === $re_pwd) && (strlen($pwd) > 6) || (preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $pwd))))
		{
            $con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $user = checkExist($username, $email, $con);
            if (!$user)
            {
                $hashpass = password_hash($pwd, PASSWORD_BCRYPT);
				$con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
				$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
				$sql = "USE ".$DB_NAME;
                $sql = "INSERT INTO users ( Username, email, Passwrd, token, active, notifications)
                VALUES (:username, :email, :pwd, :token, :activated, :notifications)";
                $stmt = $con->prepare($sql);
                
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':pwd', $hashpass);
                $stmt->bindParam(':token', $token);
                $stmt->bindParam(':activated', $active, PDO::PARAM_BOOL);
                $stmt->bindParam(':notifications', $notifi , PDO::PARAM_BOOL);
                
                if($stmt->execute()){
                    header("location:activ.php");
                }
                            $message ="
You account has been created, verify via email to log in.

-------------------
USERNAME :".$username."
-------------------
activate your account with the following link.
<a href = http://127.0.0.1:8080/camagru/verify.php?email=$email&token=$token>Verify Link</a>
Thank you $username for registering with us";
                
                $subject = "Account Activation";
                if (mail($email,$subject,$message))
                {
                    $msg = "Email received";
                    echo "<script>alert('Account verified');</script>";
                    header('location:activ.php');
                }
                else
                    die('something went wrong try again');
            }
            else
                die('Account already exists');
        }
        else
            die('something went wrong');
                $conn = null;
        }
    }
        catch(PDOException $e)
        {
            echo $stmt . "<br>" . $e->getMessage();
        }
        $conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>register</title>
    <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
    
         <div class="nav">
      <ul>
        <li class="home"><a href="index.php">Home</a></li>
        <li class="tutorials"><a href="login.php">Login</a></li>
        <li class="about"><a href= "gallery.php">Gallery</a></li>
        <li class="contact"><a class = "active" href="signup.php">Register</a></li>      
      </ul>
    </div>
    <form class="box2" action="signup.php" method="post">
        <h1>Sign Up</h1>
        <!-- <input type="text" placeholder=" First Name" name="fname" required>
        <input type="text" placeholder="Last Name" name="lname" required> -->
        <input type="text" placeholder="Username" name="username" required>
        <br>
        <input type="email" placeholder="Email Address" name="email" required>
        <br>
        <input type="password" placeholder="Password" name="pwd" required>
        <br>
        <input type="password" placeholder="ReTyped Password" name="re_pwd" required>
        <br>
        <input type="submit" name="signup" value="signup" class= "btn btn-primary">
    </form>
</body>
</html>
