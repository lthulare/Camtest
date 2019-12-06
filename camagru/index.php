<?php
session_start();
require './config/database.php';
require './config/setup.php';
//$userlog = $_SESSION['Username'];

if(isset($_SESSION['Username']))
{


  echo <<<HTML


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
        <li class="home"><a class = "active"  href="index.php">Home</a></li>
        <li class="tutorials"><a href="modify.php">Profile</a></li>
        <li class ="tutorials"><a href="cam.php">Snap</a></li>
        <li class="about"><a href= "gallery.php">Gallery</a></li>
        <li class="contact"><a href="logout.php">Logout</a></li>      
      </ul>
    </div>
        </header>
        <div style = "text-align :center">
        <h1 class="hero">Welcome User</h1>
       
            <p>This is camagru an online image sharing social media platform.</p>

           
            <img src="styleimg/welcome.jpg" class = "cenimg" style = "float : center">

          </div>
        <br>
        <br>
        <br>
        <footer>
               
                <div class="nav">
      <ul>
        <li class="home"><a href="index.php">Refresh</a></li>
        <li class="about"><a href= "logout.php">Log out</a></li>   
      </ul>
    </div>
        </footer>
    </body>
    
</html>
HTML;
}
else {
      echo <<<html

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
        <li class="home"><a class = "active"  href="index.php">Home</a></li>
        <li class="tutorials"><a href="login.php">Login</a></li>
        <li class="about"><a href= "visitor.php">Gallery</a></li>
        <li class="contact"><a href="signup.php">Register</a></li>      
      </ul>
    </div>
        </header>
        <div style = "text-align :center">
        <h1 class="hero">Welcome User</h1>
       
            <p>This is camagru and online image sharing social media platform.</p>

           
            <img src="styleimg/welcome.jpg" class = "cenimg" style = "float : center">

          </div>
        <br>
        <br>
        <br>
        <footer>
                
                <div class="nav">
      <ul>
        <li class="home"><a href="index.php">Refresh</a></li>
        <li class="tutorials"><a href="login.php">Login</a></li>
        <li class="about"><a href= "signup.php">Register</a></li>   
      </ul>
    </div>
        </footer>
    </body>
    
</html>


html;
}
?>