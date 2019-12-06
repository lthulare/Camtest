<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'config/database.php';

?>
<!doctype html>
<html>
    <head>
        <title>Signed in</title>
        <link href="css/style.css" rel="stylesheet" type="text/css">
    </head>
    
    <body>
       
        <header>
        <div class="nav">
      <ul>
        <li class="home"><a class = "active"  href="index.php">Home</a></li>
        <li class="tutorials"><a href="login.php">Login</a></li>
        <li class="about"><a href= "gallery.php">Gallery</a></li>
        <li class="contact"><a href="signup.php">Register</a></li>      
      </ul>
    </div>
        </header>
       
        <div style = "text-align :center">
        <h1 class="hero">Welcome <? echo "{$_SESSION['Username']}";?> </h1>
       
            <p>This is camagru and online image sharing social media platform.</p>

           
            <img src="styleimg/welcome.jpg" class = "cenimg" style = "float : center">

          </div>
        <br>
        <br>
        <br>
        <footer>
                <ul class="foot-nav">
                <div class="nav">
      <ul>
        <li class="home"><a href="index.php">Refresh</a></li>
        <li class="tutorials"><a href="login.php">Login</a></li>
        <li class="about"><a href= "signup.php">Register</a></li>   
      </ul>
    </div>

       
    </body>
</html>
