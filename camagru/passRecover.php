<?php

require('config/database.php');

if (!empty($_POST['email']))
{
    $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
    $email          = trim(htmlspecialchars($_POST['email']));

    try{
        $con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $con->prepare($sql);


        $stmt->bindParam(':email', $email);
        

       if(preg_match($pattern, $email) == 1){
        if($stmt->execute()){

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $vkey = $result[0]['token'];

            echo "Link was sent to the entered email.";
            $msgs = "<a href = 'http://localhost:8080/camagru/updatepass.php?token=$vkey'>Click to update password</a>";
            $email = mail("$email", "Change Password", $msgs); 
            // header('location:thankyou.php');
        }
        else
            echo "Account doesn't exist";
   }
    else 
            echo "Email entered is not valid retype";
}
    catch(Exception $e)
    {
        echo $stmt . "<br>" . $e->getMessage();
    }
    $con = null;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8">
<title>Password Recovery</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
</style>
</head>
<body style = "float :center";>
<div class="nav">
  <ul>
    <li class="home"><a href="index.php">Home</a></li>
    <li class="tutorials"><a href="login.php">Login</a></li>
    <li class="about"><a href="cam.php">Snap Image</a></li>
    <li class="contact"><a href="register.php">Register</a></li>
  </ul>
</div>
<h1 style = "text-align: center";>Password Recovery</h1>
<br>

<form method = "post" action = "">
<div style = "float : center";> <table>
    
    <tr><td>Email:</td> <td><input type = "" value = ""  title = "Enter email address" name = "email"></td></tr>
    <div class ="form-group">
    <tr><td></td><td><input style = "float: center;" type = "submit" class="btn btn-primary" value = "Sign Up" >
    <input type="reset" class="btn btn-primary" value="Reset">
    </td></tr>
</table></div>
</form>
</body>
</html>

